<?php

require_once "./dealerDataFunction.php";
$base_path = dirname(dirname(__DIR__));

global $CronConfigs, $scrapper_configs, $single_config;

$cron = isset($_GET['cron']) ? $_GET['cron'] : null;

if (empty($cron)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Blank Cron Request";
    echo json_encode($response);
    exit;
}

$single_config = $cron;

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
require_once ADSYNCPATH . '/utils.php';

require_once $base_path . '/tracking-tags/script-helper.php';

header("Access-Control-Allow-Origin: *");

$response        = [];
$response['res'] = true;

$url  = isset($_GET['url']) ? $_GET['url'] : null;
$cron = isset($_GET['cron']) ? $_GET['cron'] : null;

if (empty($url)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Blank URL Request";
    echo json_encode($response);
    exit;
}

/*
 * add Cron Config
 */

if ($CronConfigs[$cron]) {
    $cron_config = $CronConfigs[$cron];
} else {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No Cron Config File Found for $cron";
    echo json_encode($response);
    exit;
}

/*
 * add Scrapper Config
 */
if ($scrapper_configs[$cron]) {
    $scrapper_config = $scrapper_configs[$cron];
} else {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No Scrapper Config File Found for $cron";
    echo json_encode($response);
    exit;
}

/*
 * Get Page Type
 */
$page_type = resolve_dealer_page_type($scrapper_config, $url);

$response['page_type'] = $page_type;

/*
 *
 */
if ($page_type == 'vdp') {
    //    $car_data       = resolve_car_from_url($cron_name, $scrapper_config, $url, $ref_url);
    //    $response['car_data'] = $car_data;
}

/*
 * Final Response
 */
echo json_encode($response);