<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

$cron_name = filter_input(INPUT_GET, 'dealership');

if (!isset($argv[1]) && !$cron_name) {
    die('Nothing to do, need arguments.');
}

if (!$cron_name) {
    $cron_name = $argv[1];
    $argv[2]   = true; #Set $argv[2] to tell slecho to use logme
}

$worker_log_dir = __DIR__ . '/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $cron_name);

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '-fbsync.log';

ini_set("error_log", $worker_logfile);

$cron_config = null;

function logme_nostrip($text)
{
    global $worker_logfile, $cron_config;
    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, $text . "\n", FILE_APPEND);
    }
}

function logme($text)
{
    global $worker_logfile, $cron_config;
    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
    }
}

if (isset($argv[1])) {
    logme(print_r($argv, true));
    logme('Starting thread');
    $grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_fbsync_worker.php ' . $argv[1]) . ' | grep -v sudo';
    logme($grepstring);
    logme(`$grepstring`);
    if (`$grepstring | wc -l` > 1) {
        logme("already running, quitting");
        die();
    } else {
        logme("Not already running");
    }
}

require_once 'config.php';
require_once 'utils.php';
require_once 'Google/Util.php';
require_once 'db_connect.php';
require_once 'cron_misc.php';
require_once 'Facebook/Fb.php';
require_once 'Facebook/polk-data.php';
require_once 'Facebook/fb-helper.php';

use FacebookAds\Object\Values\CampaignObjectiveValues;

slecho('Initialization complete');

global $CronConfigs, $scrapper_configs, $connection, $fb_config, $fb_access_token, $fb_polk_data;

if (isset($CronConfigs[$cron_name])) {$cron_config = $CronConfigs[$cron_name];} else {slecho('Could not find configuration');exit;}
if (!isset($cron_config['fb_config'])) {slecho('Facebook configuration is not present');exit;}
if (!isset($cron_config['fb_config']['targeting'])) {slecho("Facebook targeting parameters missing, unable to continue");exit;}

$plain           = isset($cron_config['fb_config']['plain']) ? $cron_config['fb_config']['plain'] : false;
$include_stock   = isset($cron_config['fb_config']['include_stock']) ? $cron_config['fb_config']['include_stock'] : false;
$create_polkdata = isset($cron_config['fb_config']['polk_data']) ? $cron_config['fb_config']['polk_data'] : false;

$cars_db     = [];
$ads_db      = [];
$all_cars_db = [];

$db_connect = new DbConnect($cron_name);
$db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);

$db_connect->close_connection();

$stock_numbers = array_keys($all_cars_db);
$domain        = count($stock_numbers) > 0 ? GetDomain($all_cars_db[$stock_numbers[0]]['url']) : '';

$total         = 0;
$fb_fulfilled  = 0;
$car_fulfilled = 0;
$time          = time();

$lang = isset($cron_config['lang']) ? $cron_config['lang'] : 'en';
if (!defined('adlang')) {
    define('adlang', $lang);
}

#ad creation options
$formats      = ['desktop', 'mobile'];
$action_types = [
    'general' => [
        'objective' => CampaignObjectiveValues::LINK_CLICKS,
        'values'    => [Fb::ACTION_TYPE_CLICK, Fb::ACTION_TYPE_MESSENGER],
    ],
    'lead'    => [
        'objective' => CampaignObjectiveValues::LEAD_GENERATION,
        'values'    => [Fb::ACTION_TYPE_LEAD],
    ],
];
$targeting_types = ['polkdata'];

if (!$create_polkdata) {
    slecho('No campaigns are running');
    exit;
}

#setup API access
$fb = new Fb($fb_config['app_id'],
    $fb_config['app_secret'],
    $fb_access_token,
    $cron_config['fb_config']['account_id'],
    $cron_config['fb_config']['page_id'],
    $cron_config['fb_config']['pixel_id'],
    $cron_config['fb_config']['dataset'],
    $cron_config['fb_config']['form_id'],
    $cron_config);

# Load current State
$state_manager = ['delete' => []];

slecho("Requesting campaign list");

$campaigns = $fb->getCampaigns();

foreach ($campaigns as $name => $campaign) {
    standard_delay();
    slecho("Processing campaign $name");

    if (endsWith($name, '_polkdata')) {
        slecho("Requesting adsets for $name");
        $adsets = $fb->getAdSets($campaign['id']);

        if (!$adsets) {
            continue;
        }

        foreach ($adsets as $adset_name => $adset) {
            standard_delay();
            slecho("Requesting ads for $adset_name");
            $ads = $fb->getAds($campaign['id'], $adset['id']);

            foreach ($ads as $ad_name => $ad) {
                standard_delay();

                slecho("Enlisting $ad_name");

                $state_manager['delete'][$ad_name] = [
                    'id'          => $ad['id'],
                    'adset_id'    => $adset['id'],
                    'campaign_id' => $campaign['id'],
                ];
            }
        }
    }
}

$cars = get_suitable_cars($all_cars_db, $cron_config);

# Plan ahead to clear first
foreach ($cars as $car) {
    foreach ($formats as $format) {
        #Now create for each $action_types & $targeting_types
        foreach ($action_types as $action_type => $action_value) {
            foreach ($targeting_types as $targeting_type) {
                foreach ($action_value['values'] as $avalue) {
                    $ad_name = $fb->getAdName($car, $targeting_type, $avalue, $format);
                    unset($state_manager['delete'][$ad_name]);
                    slecho("Ad to archive $ad_name");
                }
            }
        }
    }
}

slecho("Processing old ads");

foreach ($state_manager['delete'] as $ad_name => $ad) {
    $fb->archiveAd($ad['campaign_id'], $ad['adset_id'], $ad['id']);
    slecho("Ad has been archived $ad_name");
    standard_delay();
}

foreach ($cars as $stock_number => $car) {
    $car['make']       = prettyString($car['make']);
    $car['model']      = prettyString($car['model']);
    $year              = $car['year'];
    $make              = $car['make'];
    $model             = $car['model'];
    $trim              = $car['trim'];
    $body_style        = $car['body_style'];
    $price             = butifyPrice($car['price']);
    $stock_type        = $car['stock_type'];
    $actual_stock_type = $car['actual_stock_type'];

    $image_url1 = count($car['images']) > 0 ? $car['images'][0] : null;
    $image_url2 = count($car['images']) > 1 ? $car['images'][1] : $image_url1;
    $image_url3 = count($car['images']) > 2 ? $car['images'][2] : $image_url1;
    $image_url4 = count($car['images']) > 3 ? $car['images'][3] : $image_url1;

    $utm_tags = isset($cron_config['utm_tags']) ? $cron_config['utm_tags'] : true;
    $url      = $car['url'];

    if ($utm_tags) {
        $url = urlCombine($url, '?utm_medium=facebook');
    }

    $min_images = isset($cron_config['banner']['min_images']) ? $cron_config['banner']['min_images'] : 1;

    $car_fulfilled++;

    foreach ($formats as $format) {
        #Create ads for each format (Currently desktop & mobile)
        if (!isset($cron_config['fb_config']['targeting'][$format])) {
            continue;
        } #Missing targeting data for this format

        if ($format && $format == 'mobile' && !($image_url1 && $image_url2 && $image_url3)) {
            continue;
        } #Any car after this is qualified for all ads

        $fb_fulfilled++;

        $sprice = $price;
        $hst    = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;
        $hst_l1 = isset($cron_config['banner']['hst_l1']) ? $cron_config['banner']['hst_l1'] : false;
        $hst_l2 = isset($cron_config['banner']['hst_l2']) ? $cron_config['banner']['hst_l2'] : false;

        if ($hst) {
            if (!$hst_l1 && !$hst_l2) {
                $sprice = "$price +HST&LIC";
            } else {
                $sprice = trim("$price $hst_l1 $hst_l2");
            }
        }

        $car['price']    = $sprice; //force templates to render with +HST&LIC
        $car['biweekly'] = butifyPrice($car['biweekly']);

        $title    = "$year $make $model";
        $fb_title = $title;

        if (numarifyPrice($price) >= 0) {
            $title = $title . ' ' . $sprice;
        }

        if ($include_stock) {
            $title .= " Stock # $stock_number";
        }

        // $biweekly = $car['biweekly'];
        if (isset($cron_config['banner']['fb_title'])) {
            $title_template = $cron_config['banner']['fb_title'];
            $title          = processTextTemplate($title_template, $car);
            $fb_title       = $title;
        }

        if (isset($cron_config['fb_title'])) {
            $title_template = $cron_config['fb_title'];
            $title          = processTextTemplate($title_template, $car);
        }

        $fb_banner_title = $fb_title;

        if (isset($cron_config['banner']['fb_banner_title'])) {
            $fb_banner_title_template = $cron_config['banner']['fb_banner_title'];
            $fb_banner_title          = processTextTemplate($fb_banner_title_template, $car);
        }

        $type          = $stock_type . 'retargeting';
        $certified_dir = __DIR__ . '/templates/' . $cron_name . '/' . 'certified-' . $type . '/';

        if ($car['certified'] && is_dir($certified_dir)) {
            $type = 'certified-' . $type;
        }

        $title_color = isset($cron_config['banner']['font_color']) ? rawurlencode($cron_config['banner']['font_color']) : '';

        $lyear  = strtolower($year);
        $lmake  = strtolower($make);
        $lmodel = strtolower($model);
        $ltrim  = strtolower($trim);

        $template_dirs = getTemplateDirs($cron_name, $type, $year, $make, $model, $trim);

        $custom_file       = map_template_path($template_dirs, "168x315.png", $cron_name);
        $custom_file_right = map_template_path($template_dirs, "356x630.png", $cron_name);
        $mobile_file       = map_template_path($template_dirs, "382x98.png", $cron_name);

        $custom_file1200 = map_template_path($template_dirs, "336x630.png", $cron_name);
        $mobile_file1200 = map_template_path($template_dirs, "1200x315.png", $cron_name);

        $banner_size = ($format && $format == 'mobile') ? ($mobile_file1200 ? 'custom-mobile1200' : ($mobile_file ? 'custom-mobile' : 'mobile')) : ($custom_file1200 ? 'custom1200' : ($custom_file || $custom_file_right ? 'custom' : '600x315'));
        $style       = isset($cron_config['banner']["fb_style_$stock_type"]) ? $cron_config['banner']["fb_style_$stock_type"] : (isset($cron_config['banner']['fb_style']) ? $cron_config['banner']['fb_style'] : ($plain ? 'plainfbad' : 'facebookad'));

        $style_to_use = apply_filters("filter_style_$cron_name", $style, $car, 'fb_style');

        if ($format == "instagram") {
            $banner_size = "1080x1080";
            //$style          = "facebookad";
        }

        if ($include_stock) {
            $banner_size = "wstock_{$banner_size}";
        }

        $params = array(
            'lang'         => $lang,
            'config'       => $banner_size,
            'template'     => $cron_name,
            'style'        => $style_to_use,
            'type'         => $type,
            'stock_number' => $stock_number,
            'year'         => $year,
            'title'        => $fb_banner_title,
            'make'         => $make,
            'model'        => $model,
            'trim'         => $trim,
            'body_style'   => $body_style,
            'price'        => $price,
            'img1'         => $image_url1,
            'img2'         => $image_url2,
            'img3'         => $image_url3,
            'img4'         => $image_url4,
            'title_color'  => $title_color,
            'hst'          => $hst ? 'true' : 'false',
            //'t'             => $time
        );

        if (isset($cron_config['banner']['marketting_lines'])) {
            $marketting_lines = $cron_config['banner']['marketting_lines']($car);
            $params           = array_merge($params, $marketting_lines);
        }

        if ($hst_l1) {
            $params['hst_l1'] = $hst_l1;
        }

        if ($hst_l2) {
            $params['hst_l2'] = $hst_l2;
        }

        $query      = http_build_query($params);
        $banner_url = "https://tm.smedia.ca/adwords3/banner.php?$query";

        #Check access token validity or die
        if (!$fb->isValidAccessToken()) {
            slecho('Access token expired');
            exit;
        }

        #Now create for each $action_types & $targeting_types
        foreach ($action_types as $action_type => $action_value) {
            foreach ($targeting_types as $targeting_type) {
                $campaign_name = $fb->getCampaignName($car, $targeting_type, $action_type);
                $campaign      = $fb->getCampaign($campaign_name);
                sleep(2);

                #Create campaign if not exist
                if (!$campaign) {
                    #Initially capmaigns are created paused
                    #ToDO: check if this behavior is required to be changed
                    $campaign = $fb->createCampaign($campaign_name, $action_value['objective']);
                    if (!$campaign) {
                        #still if not campaign?
                        slecho("Something went wrong, unable to get or create campaign");
                        exit;
                    }

                    slecho("New campaign is created Name: $campaign_name Id: {$campaign['id']}");
                    sleep(5);
                }

                $campaign_id = $campaign['id'];

                slecho("Campaign Name: $campaign_name Id: $campaign_id");

                $adset_name = $fb->getPolkdataAdsetName($car, $targeting_type, $action_type, $format);
                $adset      = $fb->getAdSet($campaign_id, $adset_name);
                sleep(2);

                #Product is new, product has changed or api error
                if (!$adset) {

                    $daily_budget = 1; //in USD

                    $targeting = $cron_config['fb_config']['targeting'][$format];

                    #Handle polk data
                    $for_all   = $fb_polk_data['value'];
                    $for_stock = $fb_polk_data[$car['stock_type']]['value'];
                    $for_make  = isset($fb_polk_data[strtolower($car['make'])]) ? $fb_polk_data[strtolower($car['make'])]['value'] : [];

                    $polk_data = array_merge($for_all, $for_stock, $for_make);

                    $behaviors = [];

                    foreach ($polk_data as $pd) {
                        $behaviors[] = [
                            'id' => $pd,
                        ];
                    }

                    $targeting['flexible_spec'] = [['behaviors' => $behaviors]];

                    if ($targeting_type == 'retargeting') {
                        $custom_audience_id = $fb->createCustomAudience($adset_name, $car);

                        if ($custom_audience_id) {
                            $targeting['custom_audiences'] = ['id' => $custom_audience_id];
                        }

                        slecho("Created custom audience Id: $custom_audience_id");
                    }

                    sleep(2);

                    $adset = $fb->createAdSet($campaign_id, $adset_name, $daily_budget, $targeting);

                    if (!$adset) {
                        #still no adest?
                        slecho("Something went wrong, unable to get or create adset");
                        exit;
                    }

                    slecho("New Adset is created Name: {$adset['name']} Id: {$adset['id']}");

                    sleep(5);
                }

                $adset_id = $adset['id'];

                #if adsets not in state,
                if (!isset($existing_ads[$adset_id])) {
                    $existing_ads[$adset_id] = $fb->getAdIds($campaign_id, $adset_id);
                }

                foreach ($action_value['values'] as $avalue) {
                    if (!in_array($avalue, $cron_config['fb_config']['action_types'])) {
                        slecho("$avalue ads are ommited by configuration, only " . implode(",", $cron_config['fb_config']['action_types']) . " will be created");
                        continue;
                    }

                    $description_template = "Test drive the [year] [make] [model] today.";

                    if (isset($cron_config['banner']['fb_description'])) {
                        $description_template = $cron_config['banner']['fb_description'];
                    }
                    if (isset($cron_config['banner']["fb_description_$stock_type"])) {
                        $description_template = $cron_config['banner']["fb_description_$stock_type"];
                    }
                    if (isset($cron_config['banner']["fb_description_$avalue"])) {
                        $description_template = $cron_config['banner']["fb_description_$avalue"];
                    }
                    if (isset($cron_config['banner']["fb_description_{$stock_type}_{$avalue}"])) {
                        $description_template = $cron_config['banner']["fb_description_{$stock_type}_{$avalue}"];
                    }
                    if (isset($cron_config['banner']["fb_description_{$lmake}"])) {
                        $description_template = $cron_config['banner']["fb_description_{$lmake}"];
                    }
                    if (isset($cron_config['banner']["fb_description_{$lmake}_{$avalue}"])) {
                        $description_template = $cron_config['banner']["fb_description_{$lmake}_{$avalue}"];
                    }
                    if (isset($cron_config['banner']["fb_description_{$stock_type}_{$lmake}"])) {
                        $description_template = $cron_config['banner']["fb_description_{$stock_type}_{$lmake}"];
                    }
                    if (isset($cron_config['banner']["fb_description_{$stock_type}_{$lmake}_{$avalue}"])) {
                        $description_template = $cron_config['banner']["fb_description_{$stock_type}_{$lmake}_{$avalue}"];
                    }

                    $description = processTextTemplate($description_template, $car); //"$make $model starting at $biweekly";

                    $ad_name = $fb->getAdName($car, $targeting_type, $avalue, $format);

                    slecho("Creating $avalue $targeting_type ad with banner $banner_url");

                    $ad = $fb->createAd($avalue, $adset_id, $car, $title, $description, $banner_url, $targeting_type, $format);

                    if ($ad) {
                        slecho("Ad is created");
                        slecho("Ad Name: $ad_name Id: $ad_id");
                    } else {
                        slecho("Failed to create ad, check error message");
                    }

                    #Wait 120 seconds before procceeding to create new ads
                    sleep(120);
                }
            }
        }
    }
}

slecho("Number of elegible cars $car_fulfilled");
slecho("Number of ads: $fb_fulfilled");
slecho("************************ End of Facebook Sync ************************");
