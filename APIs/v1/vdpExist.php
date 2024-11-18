<?php

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
require_once ADSYNCPATH . '/utils.php';

header("Access-Control-Allow-Origin: *");

global $CronConfigs, $scrapper_configs;

$response        = [];
$response['res'] = true;

$cron = isset($_GET['cron']) ? $_GET['cron'] : null;

if (empty($cron)) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "Blank cron Request";
    $response['car']     = [];
    echo json_encode($response);
    exit;
}

if (!$CronConfigs[$cron]) {
    $response            = [];
    $response['res']     = false;
    $response['message'] = "No cron exist";
    $response['car']     = [];
    echo json_encode($response);
    exit;
}

$table  = $cron . "_scrapped_data";
$query  = "SELECT url, stock_type FROM {$table} WHERE deleted = 0 GROUP BY stock_type";
$result = DbConnect::get_connection_read()->query($query);

if (mysqli_num_rows($result)) {
    $car = [];

    while ($details = mysqli_fetch_assoc($result)) {
        $car[$details['stock_type']] = $details['url'];
    }

    $response               = [];
    $response['res']        = true;
    $response['active_vdp'] = true;
    $response['message']    = "Active VDP found in scrap table";
    $response['car']        = $car;
    echo json_encode($response);
} else {
    $response               = [];
    $response['res']        = true;
    $response['active_vdp'] = false;
    $response['message']    = "No active VDP found in scrap table";
    $response['car']        = [];
    echo json_encode($response);
}