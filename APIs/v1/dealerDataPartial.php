<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once __DIR__ . "/dealerDataFunction.php";

$response   = [];
$dealer_url = isset($_GET['url']) ? smediaUrlDecrypt($_GET['url']) : null; // Just the domain will suffice // The superglobals $_GET and $_REQUEST are already decoded

if (empty($dealer_url)) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => 'Blank URL Request'], JSON_PRETTY_PRINT);
    exit();
}

$base_path = dirname(dirname(__DIR__));
$tmp_path  = dirname(dirname(__FILE__));
$abs_path  = str_replace('\\', '/', $base_path);

if (!defined('TT_ABSPATH')) {
    define('TT_ABSPATH', $abs_path);
}

if (!defined('STOP_ADDING_CONFIG_PHP_EVERYWHERE_FOR_CRYING_OUT_LOUD')) {
    define('STOP_ADDING_CONFIG_PHP_EVERYWHERE_FOR_CRYING_OUT_LOUD', true);
}

################################################################################
# Following lines are required because
# `$base_path . '/dashboard/config.php';` Is used. It would redirect hits on
# `tm.smedia.ca` to `tools.smedia.ca` without this NO_REDIRECT flag
################################################################################
if (!defined("NO_REDIRECT")) {
    define("NO_REDIRECT", true);
}

require_once $base_path . '/dashboard/config.php';
require_once $base_path . '/dashboard/includes/default-values.php';
require_once ADSYNCPATH . '/tag_db_connect.php';

global $CronConfigs, $scrapper_configs, $install_trade_smart, $v2_dealerinfo, $single_config, $smart_memo_default, $vinnauto_default, $default_tag_controls;

$smedia_debug = false;

if (isset($_GET['smedia_debug']) && $_GET['smedia_debug'] == "true") {
    $smedia_debug = true;
}

$single_config = function () use ($dealer_url) {
    $domain = GetDomain($dealer_url);
    return get_meta('dealer_domain', $domain);
};

require_once ADSYNCPATH . '/config.php';
require_once ADSYNCPATH . '/utils.php';
require_once $base_path . '/tracking-tags/script-helper.php';

$domain = GetDomain($dealer_url);

require_once $base_path . '/tracking-tags/init-db.php';
require_once 'aiButton.php';

$response['domain'] = $domain;
$blackList          = blackListCheck($domain);

// Send IP
$response['ip'] = $blackList['ip'];

if ($blackList['res']) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "Black listed ip " . $blackList['ip']], JSON_PRETTY_PRINT);
    exit();
}

$domainOnly = domaitoUrl($domain);

if (empty($domainOnly)) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => 'Blank Domain'], JSON_PRETTY_PRINT);
    exit();
}

$decided_dealership = $smedia_debug ? $single_config : get_meta('dealer_domain', $domain);

if (!$decided_dealership) {
    $decided_dealership = get_meta('dealer_domain', $domain);
}

$cache_file_dir = DEALER_DATA_CACHE . $decided_dealership;

if (!file_exists($cache_file_dir)) {
    mkdir($cache_file_dir, 0777, true);
}

$cache_file_name = "{$cache_file_dir}/dealer_data-{$domain}.json";
$cache_period    = 12 * 3600;

if (!$smedia_debug && file_exists($cache_file_name)) {
    if ((time() - filemtime($cache_file_name)) < $cache_period) {
        echo file_get_contents($cache_file_name);
        exit();
    } else {
        unlink($cache_file_name);
    }
}

$dealershipTableData = getDealerData($decided_dealership);

// Dealer Not Found
if (empty($dealershipTableData)) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "No Dealer Found where dealer url like {$domainOnly}."], JSON_PRETTY_PRINT);
    exit();
}

// Dealer inactive
if (!in_array($dealershipTableData['status'], ['active', 'trial'])) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "Dealer status is " . $dealershipTableData['status'] . " in DB."], JSON_PRETTY_PRINT);
    exit();
}

$cron             = $dealershipTableData['dealership'];
$response['cron'] = $cron;

$sendArray = ['company_name', 'group_name', 'address', 'city', 'state', 'post_code', 'currency', 'country_name', 'phone', 'fb_page_id', 'status', 'buttons_live', 'form_live', 'snapchat_feed_export', 'google_account_id', 'bing_account_id', 'scrapper_type', 'dealer_type', 'pixel_content_id_field'];

foreach ($dealershipTableData as $key => $value) {
    if (in_array($key, $sendArray)) {
        $response['dealer_info'][$key] = trim($value);
    }
}

$tag_controls = unserialize($dealershipTableData['tag_controls']);

$response['dealer_info']['tag_controls'] = !!$tag_controls ? $tag_controls : $default_tag_controls;

// Mongo Dealer Info
$api_host = 'https://api.smedia.ca';
$version  = 'v1';

if (isset($_GET['server']) && !!$_GET['server']) {
    $api_host = "https://" . $_GET['server'] . ".smedia.ca";
}

$dealer_id_pull = "{$api_host}/{$version}/dealer-exist/{$domain}";
$dealer_resp    = HttpGet($dealer_id_pull);
$dealerships    = json_decode($dealer_resp);

if ($dealerships->dealer) {
    $response['mongo_dealer_info']['exist'] = true;
    $response['mongo_dealer_info']['id']    = $dealerships->dealershipId;
    $response['smart_offer_control']        = $dealerships->smart_offer_control;

    // Smart Offer
    $sm_con_url = "{$api_host}/{$version}/sm-config-public/{$dealerships->dealershipId}";
    $sm_con_res = HttpGet($sm_con_url);

    if ($sm_con_res) {
        $json_resp                           = json_decode($sm_con_res);
        $response['services']['smart_offer'] = $json_resp->data->config;
    }

    // Smart Profiler
    $sp_con_url = "{$api_host}/{$version}/sp-config/{$dealerships->dealershipId}";
    $cookie = '';
    $content_type = 'application/x-www-form-urlencoded';
    $additional_headers = [
        'masterToken' => '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b'
    ];
    $sp_con_res = HttpGet($sp_con_url, false, false, $cookie, $cookie, $content_type, $additional_headers);

    if ($sp_con_res) {
        $json_resp                              = json_decode($sp_con_res);
        $response['services']['smart_profiler'] = $json_resp->data->config;
    }
} else {
    $response['mongo_dealer_info']['exist'] = false;
    $response['mongo_dealer_info']['id']    = "";
    $response['smart_offer_control']        = null;
}

// Trade Smart Info
if ($install_trade_smart) {
    $response['dealer_info']['tradesmart']           = true;
    $response['dealer_info']['tradesmart_dealer_id'] = $v2_dealerinfo['id'];
} else {
    $response['dealer_info']['tradesmart']           = false;
    $response['dealer_info']['tradesmart_dealer_id'] = null;
}

// Add Cron Config
if ($CronConfigs[$cron]) {
    $cron_config = $CronConfigs[$cron];

    $response['cron_config'] = [
        'name'                => isset($cron_config['name']) ? $cron_config['name'] : $domain,
        'customer_id'         => isset($cron_config['customer_id']) ? $cron_config['customer_id'] : null,
        'bing_account_id'     => isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : null,
        'perfect_audience_id' => isset($cron_config['perfect_audience_id']) ? $cron_config['perfect_audience_id'] : '',
        'post_code'           => isset($cron_config['post_code']) ? $cron_config['post_code'] : '',
        'vdp_views'           => isset($cron_config['vdp_views']) ? $cron_config['vdp_views'] : false,
        'lead'                => isset($cron_config['lead']) ? $cron_config['lead'] : null,
        'buttons'             => isset($cron_config['buttons']) ? $cron_config['buttons'] : null,
        'trackers'            => isset($cron_config['trackers']) ? $cron_config['trackers'] : null,
        'vinnauto'            => isset($cron_config['vinnauto']) ? $cron_config['vinnauto'] : $vinnauto_default,
        'cities'              => isset($cron_config['cities']) ? $cron_config['cities'] : null,
        'tag_debug'           => isset($cron_config['tag_debug']) ? $cron_config['tag_debug'] : false,
        'tag_settings'        => isset($cron_config['tag_settings']) ? $cron_config['tag_settings'] : false,
        'retargetting_delay'  => isset($cron_config['retargetting_delay']) ? $cron_config['retargetting_delay'] : 0,
        'mail_retargeting'    => isset($cron_config['mail_retargeting']) ? $cron_config['mail_retargeting'] : null,
        'combined_feed_mode'  => isset($cron_config['combined_feed_mode']) ? $cron_config['combined_feed_mode'] : false,
        'powered_by_live'     => isset($cron_config['powered_by_live']) ? $cron_config['powered_by_live'] : false,
        'form_disclaimer'     => isset($cron_config['form_disclaimer']) ? $cron_config['form_disclaimer'] : "",
        'enable_button'       => (isset($cron_config['tag_settings']) && isset($cron_config['tag_settings']['button'])) ? $cron_config['tag_settings']['button'] : true,
        'enable_tracking'     => (isset($cron_config['tag_settings']) && isset($cron_config['tag_settings']['event_tracking'])) ? $cron_config['tag_settings']['event_tracking'] : true,
        'smart_banner'        => isset($cron_config['smart_banner']) ? $cron_config['smart_banner'] : null
    ];
} else {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "No Cron Config File Found for {$cron}."], JSON_PRETTY_PRINT);
    exit();
}

// Add Scrapper Config
if ($scrapper_configs[$cron]) {
    $scrapper_config             = $scrapper_configs[$cron];
    $response['scrapper_config'] = [
        'vdp_url_regex'          => isset($scrapper_config['vdp_url_regex']) ? $scrapper_config['vdp_url_regex'] : null,
        'picture_selectors'      => isset($scrapper_config['picture_selectors']) ? $scrapper_config['picture_selectors'] : null,
        'picture_nexts'          => isset($scrapper_config['picture_nexts']) ? $scrapper_config['picture_nexts'] : null,
        'picture_prevs'          => isset($scrapper_config['picture_prevs']) ? $scrapper_config['picture_prevs'] : null,
        'next_page_regx'         => isset($scrapper_config['next_page_regx']) ? $scrapper_config['next_page_regx'] : null,
        'images_regx'            => isset($scrapper_config['images_regx']) ? $scrapper_config['images_regx'] : null,
        'images_fallback_regx'   => isset($scrapper_config['images_fallback_regx']) ? $scrapper_config['images_fallback_regx'] : null,
        'inpage_cont_match'      => isset($scrapper_config['inpage_cont_match']) ? $scrapper_config['inpage_cont_match'] : null,
        'ajax_url_match'         => isset($scrapper_config['ajax_url_match']) ? $scrapper_config['ajax_url_match'] : null,
        'ajax_resp_match'        => isset($scrapper_config['ajax_resp_match']) ? $scrapper_config['ajax_resp_match'] : null,
        'ajax_debug'             => isset($scrapper_config['ajax_debug']) ? $scrapper_config['ajax_debug'] : null,
        'client_scrapping'       => isset($scrapper_config['client_scrapping']) ? $scrapper_config['client_scrapping'] : null,
        'url_resolve'            => isset($scrapper_config['url_resolve']) ? $scrapper_config['url_resolve'] : null,
        'data_capture_regx_full' => getDataCaptureRegexFull($scrapper_config),
    ];
} else {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "No Scrapper Config File Found for {$cron}."], JSON_PRETTY_PRINT);
    exit();
}

// Get Page Type
$response['page_type']    = resolve_dealer_page_type($scrapper_config, $dealer_url);
$response['multi_dealer'] = isset($scrapper_config['url_resolve']) ? true : false;

// Get Tag Config
if ($response['multi_dealer']) {
    $response['single_tag_config'] = null;
    $response['multi_tag_config']  = getMultiTagConfigData($domainOnly);
} else {
    $response['single_tag_config'] = getSingleTagConfig($cron);
    $response['multi_tag_config']  = null;
}

// AI Button Algorithms
if (isset($CronConfigs[$cron]['button_algorithm'])) {
    $ai_button_algorithm = explode('|', $CronConfigs[$cron]['button_algorithm']);
} else {
    $ai_button_algorithm = ['default'];
}

$response['ai_button'] = isset($CronConfigs[$cron]['buttons']) ? ai_button_data($cron, $CronConfigs[$cron]['buttons'], $ai_button_algorithm) : null;

// Smedia domains
$response['smedia_domains'] = [
    'tradesmart'  => 'https://tradesmartapi.smedia.ca',
    'smedia_api'  => $api_host,
    'script_host' => 'https://tm.smedia.ca',
    'tools_host'  => 'https://tools.smedia.ca',
    'crawler_api' => 'https://crawler-api.smedia.ca',
    'event_host'  => 'https://events.smedia.ca',
];

if ($smedia_debug) {
    $response['source'] = 'realtime';
    $response['mode']   = 'debug';
} else {
    $response['source'] = 'realtime';
    $response['mode']   = 'regular';
}

$final_output_resp = ['data' => $response, 'success' => true, 'message' => "Everything found successfully."];

// Final Response
echo json_encode($final_output_resp);

$response['source'] = 'cached';
$response['mode']   = 'cached';

$cached_output_resp = ['data' => $response, 'success' => true, 'message' => "Everything found successfully."];
$cache_output       = json_encode($cached_output_resp);
file_put_contents($cache_file_name, $cache_output);
chmod($cache_file_name, 0777);