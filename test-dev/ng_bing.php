<?php

ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$argv[2] = 'marshal';

$_SERVER['HTTPS']       = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

$_GET['customer'] = $argv[2];

global $single_config;
$cron_name = $single_config = filter_input(INPUT_GET, 'dealership');
if ($cron_name && !empty($cron_name)) {
    $argv[1] = $cron_name;
} else {
    die('Nothing to do, need arguments dealership !!!!!!!!!');
}

require_once '../adwords3/config.php';
require_once '../adwords3/utils.php';
require_once '../adwords3/Google/TokenHelper.php';
require_once '../adwords3/Google/Types.php';
require_once '../adwords3/Google/Util.php';
require_once '../adwords3/Google/Consts.php';
require_once '../adwords3/Google/Adwords.php';
require_once '../adwords3/Google/Analytics.php';
require_once '../adwords3/Google/SessionManager.php';
require_once '../adwords3/cron_misc.php';
require_once '../adwords3/db_connect.php';
require_once '../adwords3/AdSyncer.php';
require_once '../adwords3/scrapper.php';

/*
 * For bing ads included these file
 */
require_once '../adwords3/bing/adSyncer.php';
require_once '../adwords3/bing/myBingAds.php';

require_once '../adwords3/carlist-loader.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
$market_buyers, $SWFConfigs, $connection, $proxy_list, $area_proxy, $carlist, $advanced_carlist,
$BannerConfigs, $number_of_retries, $worker_logfile;

if (array_key_exists($cron_name, $CronConfigs)) {
    $scrapper_config = $scrapper_configs[$cron_name];
    $cron_config     = $CronConfigs[$cron_name];
} else {
    die("This dealership is either invalid or inactive, Invalid dealer name. Give a valid dealer name!!!!!!!!!!!!!!!!");
}

/*
 * Check bing ads applicable for this dealer or not, if applicable then call bing ads
 */
$db_connect         = new DbConnect($cron_name);
$dealership_details = $db_connect->get_dealer_details($cron_name);
$db_connect->close_connection();
$worker_logfile = dirname(__DIR__) . '/adwords3/caches/bingads-log/' . $cron_name . '.txt';

if (in_array('Bing Ads', $dealership_details['campaign_types'])) {
    writeLog($worker_logfile, "---------------Starting bing ads for '" . $cron_name . "'---------------");
    //    SyncBingAd($cron_name, $cron_config, $worker_logfile);
    SyncBingAdDebug($cron_name, $cron_config, $worker_logfile);
}

function SyncBingAdDebug($cron_name, $cron_config, $log_file_path = null)
{

    $account_id = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
    if (!$account_id) {
        writeLog($log_file_path, "no bing account id found for $cron_name");
        echo "no bing account id found for $cron_name<br>";
        return 0;
    }

    $db_connect = new DbConnect($cron_name);

    $cars_new     = array();
    $cars_updated = array();
    $cars_deleted = array();
    $cars_all     = array();
    $db_connect->LoadCarBingAds($cars_new, $cars_updated, $cars_deleted, $cars_all, $cron_config);

    writeLog($log_file_path, "***** Try Bing Authentication");

    getAuthentication($account_id, $log_file_path);

    writeLog($log_file_path, "***** Bing Authentication");

    $db_connect->bing_sleep();
    $allCampaign = getAllCampaign($account_id);
    $Campaigns   = $allCampaign->Campaigns;
    $campaignIds = [];

    if (count((array) $Campaigns)) {
        $Campaign = $Campaigns->Campaign;
        foreach ($Campaign as $campaign_data) {
            $campaignIds[$campaign_data->Name] = $campaign_data->Id;
        }
    }

    $CpcBid = isset($cron_config['bing_bid']) ? $cron_config['bing_bid'] : 0.05;

    /*
     * ONLY FOR NEW CARS
     * Create Ads, Ads group, Campaign based on need
     */
    writeLog($log_file_path, "***** Total Number of New Car" . count($cars_new));
    echo "***** Total Number of New Car" . count($cars_new);
    foreach ($cars_new as $stock_number => $car) {
        $stock_type  = $car['stock_type'];
        $budget_name = $campaign_name = $stock_type . '_search';
        if (isset($cron_config['bing_create'])) {
            $create_ads = isset($cron_config['bing_create'][$campaign_name]) ? $cron_config['bing_create'][$campaign_name] : false;
        } else {
            $create_ads = true;
        }
        if ($create_ads) {
            try {
                writeLog($log_file_path, "car url:" . $car['url']);
                echo "car url:" . $car['url'] . '<br>';
                if (isset($campaignIds[$campaign_name])) {
                    $searchCampaignId = $campaignIds[$campaign_name];
                } else {
                    $db_connect->bing_sleep();
                    $budgetId = createBudget($budget_name);
                    $db_connect->bing_sleep();
                    $searchCampaignId            = createCampaign($account_id, $budgetId, $campaign_name);
                    $campaignIds[$campaign_name] = $searchCampaignId;
                    $negative_keywords           = getNegativeKeywords($car);
                    $db_connect->bing_sleep();
                    setNegativeKeywordDebug($searchCampaignId, $negative_keywords);
                }
                writeLog($log_file_path, "campaign id: $searchCampaignId");
                echo "campaign id: $searchCampaignId";
                $adGroups      = getAdGroupsByCampaignId($searchCampaignId);
                $ad_group_name = get_ad_group_name($car, $cron_name);

                if (array_key_exists($ad_group_name, $adGroups)) {
                    $adGroupId = $adGroups[$ad_group_name]->Id;
                } else {
                    $db_connect->bing_sleep();
                    $adGroupId = createAdGroup($searchCampaignId, $CpcBid, $ad_group_name);
                    $keywords  = getKeywords($car);
                    $db_connect->bing_sleep();
                    setPositiveKeywordDebug($adGroupId, $keywords);
                }
                writeLog($log_file_path, "ad group id: $adGroupId");
                echo "ad group id: $adGroupId";
                $db_connect->bing_sleep();
                createAdsDebug($adGroupId, $car, $cron_config, $cron_name, $log_file_path, $db_connect);
            } catch (Exception $ex) {
                writeLog($log_file_path, "###Exception: " . $ex->getMessage());
                writeLog($log_file_path, "###Exception code: " . $ex->getCode());
                writeLog($log_file_path, "###Exception trace: " . $ex->getTraceAsString());
            }
        }
    }

    $db_connect->close_connection();
}

function createAdsDebug($adGroupId, $car, $cron_config, $cron_name, $log_file_path, $db_connect)
{
    writeLog($log_file_path, "****Creat ads call");
    $headline = getTextHeadline($car, $cron_config, "[year] [make] [model] [price]", false);
    writeLog($log_file_path, 'headline : ' . $headline);
    $headline2 = getTextHeadline2($car, $cron_config);
    writeLog($log_file_path, 'headline2 : ' . $headline2);

    $temp_url     = str_replace('>', '', str_replace('&amp;', '&', $car["url"]));
    $AdUrlDisplay = str_replace(' ', '%20', $temp_url);
    if ($AdUrlDisplay == '') {
        writeLog($log_file_path, "no add url found");
        return 0;
    }

    //utm_source is removed according to Emil's request on 05/02/2020
    //https://app.asana.com/0/687248649257779/1159990434790489
    $directive    = 'bing_smedia';
    $directivekey = $car['stock_type'] . $directive;
    $cam_search   = "smedia_search_" . $car['stock_type'];
    $AdUrlDisplay = add_query_arg(["utm_source" => $directive, "utm_medium" => "cpc", "utm_campaign" => $cam_search], $AdUrlDisplay);

    writeLog($log_file_path, 'get Descs call');

    $descs = getDescsDebug($car, $cron_name, $cron_config, 'search', $log_file_path);

    writeLog($log_file_path, 'get Descs Count ' . count($descs));
    foreach ($descs as $desc) {
        writeLog($log_file_path, '$desc' . $desc);
        $title2       = $desc['title2'];
        $title3       = $desc['title3'];
        $description  = $desc['description'];
        $description2 = $desc['description2'];

        if (!$title2) {
            $title2 = $headline2;
        }

        writeLog($log_file_path, "ad url display: $AdUrlDisplay");
        $adCreate = expandedTextAds($adGroupId, $headline, $title2, $title3, $description, $description2, $AdUrlDisplay);
        $ad_id    = $adCreate->AdIds->long[0];
        writeLog($log_file_path, "created ad id no: $ad_id");
    }

    if ($ad_id) {
        writeLog($log_file_path, "Handled ad id: $ad_id  | stock number {$car['stock_number']}");
        $db_connect->update_bing_handled($car['stock_number']);
    }
}

function setPositiveKeywordDebug($adGroupId, $keywords)
{
    for ($i = 0; $i < count($keywords); $i++) {
        addKeyword($adGroupId, $keywords[$i]); //Broad Match Type
        addKeyword($adGroupId, '+' . str_replace(' ', ' +', $keywords[$i])); //Broad Modifier Match Type
        addKeyword($adGroupId, '"' . $keywords[$i] . '"', 'Phrase'); //Phrase Match Type
        addKeyword($adGroupId, '[' . $keywords[$i] . ']', 'Exact'); //Exact Match Type
    }
}

function setNegativeKeywordDebug($searchCampaignId, $negative_keywords)
{
    foreach ($negative_keywords as $negative_keyword) {
        addNegativeKeyword($searchCampaignId, $negative_keyword);
    }
}

function getDescsDebug($car, $cron_name, $cron_config, $campaign, $log_file_path)
{
    $retval = [];

    $descs = apply_filters("filter_{$cron_name}_description", isset($cron_config["{$car['stock_type']}_descs"]) ? $cron_config["{$car['stock_type']}_descs"] : [], $car, $campaign);

    writeLog($log_file_path, "Description template count: " . count($descs));

    foreach ($descs as $desc) {
        writeLog($log_file_path, 'desc' . $desc);
        $title2       = isset($desc['title2']) ? processTextTemplate($desc['title2'], $car, true) : null;
        $title3       = isset($desc['title3']) ? processTextTemplate($desc['title3'], $car, true) : 'View Prices, Deals and Offers';
        $desc1        = isset($desc['desc1']) ? processTextTemplate($desc['desc1'], $car, true) : null;
        $desc2        = isset($desc['desc2']) ? processTextTemplate($desc['desc2'], $car, true) : null;
        $old_desc     = isset($desc['desc']) ? processTextTemplate($desc['desc'], $car, true) : null;
        $description  = isset($desc['description']) ? processTextTemplate($desc['description'], $car, true) : $old_desc;
        $description2 = isset($desc['description2']) ? processTextTemplate($desc['description2'], $car, true) : 'See Inventory, Specs & Get a Quote. Call Today & Schedule A Test Drive!';

        writeLog($log_file_path, "Desc1: '$desc1'");
        writeLog($log_file_path, "Desc2: '$desc2'");

        if (!$description && ($desc1 && $desc2)) {
            $description = "$desc1 $desc2";
        }

        if ($description) {
            $retval[] = [
                'title2'       => $title2,
                'title3'       => $title3,
                'description'  => $description,
                'description2' => $description2,
            ];
        } else {
            writeLog($log_file_path, "Description template was: " . json_encode($desc));
        }
    }

    writeLog($log_file_path, "Description count: " . count($retval));

    return $retval;
}
