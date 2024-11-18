<?php

require_once "./dealerDataFunction.php";
$base_path = dirname(dirname(__DIR__));

################################################################################
# Following line is required because
# `$base_path . '/dashboard/config.php';` Is used. It would redirect hits on
# `tm.smedia.ca` to `tools.smedia.ca` without this NO_REDIRECT flag
################################################################################

if (!defined("NO_REDIRECT")) {
    define("NO_REDIRECT", true);
}

require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . '/config.php';
require_once ADSYNCPATH . '/db_connect.php';
require_once $base_path . '/tracking-tags/script-helper.php';

header("Access-Control-Allow-Origin: *");

global $CronConfigs, $scrapper_configs;

$response        = [];
$response['res'] = true;

$url = isset($_GET['url']) ? $_GET['url'] : null; // Just the domain will suffice

if (empty($url)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Blank URL Request";
    echo json_encode($response);
    exit;
}

$domain             = GetDomain($url);
$response['domain'] = $domain;

/*
 * Check Black list
 */
$blackList = blackListCheck($domain);

if ($blackList['res']) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Black listed ip " . $blackList['ip'];
    echo json_encode($response);
    exit;
}

/*
 * Get url without http/https/www
 */
$domainOnly = domaitoUrl($domain);

if (empty($domainOnly)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Blank Domain";
    echo json_encode($response);
    exit;
}

/*
 * Get Data from dealerships
 */
$dealershipTableData = getCronNameByUrl($domainOnly);
if (empty($dealershipTableData)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No Dealer Found where dealer url like $domainOnly";
    echo json_encode($response);
    exit;
}

$check = ['active', 'trial'];

if (!in_array($dealershipTableData['status'], $check)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = " Dealer status is " . $dealershipTableData['status'] . " in dealerships DB";
    echo json_encode($response);
    exit;
}

$cron             = $dealershipTableData['dealership'];
$response['cron'] = $cron;

$sendArray = ['campaign_types', 'star_to', 'adf_to', 'lead_to', 'lead_from', 'buttons_live', 'form_live', 'snapchat_feed_export', 'google_account_id', 'bing_account_id'];
foreach ($dealershipTableData as $key => $value) {
    if (in_array($key, $sendArray)) {
        $response[$key] = $value;
    }
}

/*
 * add Cron Config
 */
if ($CronConfigs[$cron]) {
    $response['cron_config'] = $CronConfigs[$cron];
} else {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No Cron Config File Found for {$cron}.";
    echo json_encode($response);
    exit;
}

/*
 * add Scrapper Config
 */
if ($scrapper_configs[$cron]) {
    $response['scrapper_config'] = $scrapper_configs[$cron];
    $scrapper_config             = $scrapper_configs[$cron];
} else {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No Scrapper Config File Found for {$cron}.";
    echo json_encode($response);
    exit;
}

/*
 * Get Page Type
 */
$page_type             = resolve_dealer_page_type($scrapper_config, $url);
$response['page_type'] = $page_type;

/*
 * Final Response
 */
echo json_encode($response);