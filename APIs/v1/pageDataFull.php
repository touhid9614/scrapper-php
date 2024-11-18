<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once __DIR__ . "/dealerDataFunction.php";

global $CronConfigs, $scrapper_configs, $single_config, $redis, $debug;
$base_path = dirname(dirname(__DIR__));

################################################################################
# Following lines are required because
# `$base_path . '/dashboard/config.php';` Is used. It would redirect hits on
# `tm.smedia.ca` to `tools.smedia.ca` without this NO_REDIRECT flag
################################################################################
if (!defined("NO_REDIRECT")) {
    define("NO_REDIRECT", true);
}

require_once $base_path . '/dashboard/config.php';
require_once ADSYNCPATH . '/utils.php';

$response        = [];
$actual_incoming = $_GET['url']; // The superglobals $_GET and $_REQUEST are already decoded
$incoming_url    = (isset($actual_incoming) && !empty($actual_incoming)) ? smediaUrlDecrypt(mild_url_encode(remove_url_fragment($actual_incoming))) : null;

if (!$incoming_url || empty($incoming_url)) {
    echo json_encode(['data' => $response, 'success' => false, 'message' => 'Blank URL Request'], JSON_PRETTY_PRINT);
    exit;
}

// echo $incoming_url; exit();

$smedia_debug = false;

if (isset($_GET['smedia_debug']) && $_GET['smedia_debug'] == "true") {
    $smedia_debug = true;
}

$single_config = function () use ($incoming_url) {
    return getDealershipFromURL($incoming_url);
};

require_once ADSYNCPATH . '/db_connect.php';
require_once ADSYNCPATH . '/tag_db_connect.php';
require_once ADSYNCPATH . '/config.php';
require_once $base_path . '/tracking-tags/script-helper.php';
require_once $base_path . '/constants.php';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$cron            = $single_config;
$cache_file_dir  = DEALER_DATA_CACHE . $cron . "/";
$cache_file_name = $cache_file_dir . base64_encode($actual_incoming) . ".json";

if (!file_exists($cache_file_dir)) {
    mkdir($cache_file_dir, 0777, true);
}

if (!$smedia_debug && file_exists($cache_file_name)) {
    echo file_get_contents($cache_file_name);
    exit();
}

$response['cron_name'] = $cron;
$response['url']       = $incoming_url;

// Add Cron Config
if ($CronConfigs[$cron]) {
    $cron_config = $CronConfigs[$cron];
} else {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "No Cron Config File Found for {$cron}."], JSON_PRETTY_PRINT);
    exit();
}

// Add Scrapper Config
if ($scrapper_configs[$cron]) {
    $scrapper_config = $scrapper_configs[$cron];
} else {
    echo json_encode(['data' => $response, 'success' => false, 'message' => "No Scrapper Config File Found for {$cron}."], JSON_PRETTY_PRINT);
    exit();
}

// Get Page Type
$page_type             = resolve_dealer_page_type($scrapper_config, $incoming_url);
$response['page_type'] = $page_type;

if ($page_type == 'vdp') {
    $car_data             = resolve_car_from_url($cron, $scrapper_config, removeParams($incoming_url), $incoming_url);
    $response['car_data'] = $car_data;
}

$stock_type = $make = $model = $year = "";

if (isset($car_data) && is_array($car_data)) {
    $stock_type = array_key_exists('stock_type', $car_data) ? strtolower($car_data['stock_type']) : "";
    $year       = array_key_exists('year', $car_data) ? $car_data['year'] : "";
    $make       = array_key_exists('make', $car_data) ? strtolower($car_data['make']) : "";
    $model      = array_key_exists('model', $car_data) ? strtolower($car_data['model']) : "";
}

$dir         = ADWORDS_DIR . "/templates/{$cron}/";
$bg_file     = '';
$multi_model = str_replace(" ", "_", $model);
$so_file     = "";

$smartOfferImages = [
    "{$stock_type}-{$year}-{$make}-{$multi_model}-popup-bg.png",
    "{$stock_type}-{$make}-{$multi_model}-popup-bg.png",
    "{$stock_type}-{$year}-popup-bg.png",
    "{$stock_type}-{$make}-popup-bg.png",
    "{$stock_type}-{$multi_model}-popup-bg.png",
    "{$year}-{$make}-{$multi_model}-popup-bg.png",
    "{$year}-{$make}-popup-bg.png",
    "{$year}-{$multi_model}-popup-bg.png",
    "{$make}-{$multi_model}-popup-bg.png",
    "{$stock_type}-popup-bg.png",
    "{$year}-popup-bg.png",
    "{$make}-popup-bg.png",
    "{$multi_model}-popup-bg.png",
    "service-popup-bg.png",
    "popup-bg.png",
];

foreach ($smartOfferImages as $f) {
    $file_path = $dir . $f;

    if (file_exists($file_path)) {
        $so_file = $f;
        break;
    }
}

if (!empty($so_file)) {
    $response['smart_offer_image_url'] = strtolower("https://tm.smedia.ca/adwords3/templates/{$cron}/{$so_file}");
}

$smartMemoFiles = [
    "{$stock_type}-smart-memo-bg.png",
    "service-smart-memo-bg.png",
    "popup-bg.png",
];

$sf_file = "";

foreach ($smartMemoFiles as $f) {
    if (file_exists($dir . $f)) {
        $sf_file = $f;
        break;
    }
}

if (removeTrailSlash(removeParams($incoming_url)) == removeTrailSlash($cron_config['smart_memo']['home_url'])) {
    $fil = "home-smart-memo-bg.png";

    if (file_exists($dir . $fil)) {
        $sf_file = $fil;
    }
}

if (!empty($sf_file)) {
    $response['smart_memo_image_url'] = strtolower("https://tm.smedia.ca/adwords3/templates/{$cron}/{$sf_file}");
}

// Might be used to store anything. Data type set to `string|Record<string, string>`
$response['additional_payload'] = '';

if ($smedia_debug) {
    $response['source'] = 'realtime';
    $response['mode']   = 'debug';
} else {
    $response['source'] = 'realtime';
    $response['mode']   = 'regular';
}

// Final Response
$resp_payload = ['data' => $response, 'success' => true, 'message' => "Successfully fetched data."];

echo json_encode($resp_payload);

$response['source'] = 'cached';
$response['mode']   = 'cached';

// Final Response
$cache_payload = ['data' => $response, 'success' => true, 'message' => "Successfully fetched data."];
$cache_output  = json_encode($cache_payload);
file_put_contents($cache_file_name, $cache_output);
chmod($cache_file_name, 0777);