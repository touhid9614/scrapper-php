<?php
header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ERROR | E_PARSE);

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'tag_db_connect.php';

if (!defined("NO_REDIRECT")) {
	define("NO_REDIRECT", true);
}


$cron = isset($_GET['cron']) ? $_GET['cron'] : null; // Just the domain will suffice

if (empty($cron)) {
	$response            = [];
	$response['res']     = false;
	$response['message'] = "Blank Cron Request";
	echo json_encode($response);
	exit;
}

$db_connect = new DbConnect();

$dealer_info = $db_connect->get_dealer_details($cron);

if (empty($dealer_info)) {
	$response            = [];
	$response['res']     = false;
	$response['message'] = "No Dealer Found";
	echo json_encode($response);
	exit;
}

echo json_encode($dealer_info);
