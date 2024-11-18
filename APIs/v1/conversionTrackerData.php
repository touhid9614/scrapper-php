<?php

$base_path = dirname(dirname(__DIR__));

global $CronConfigs, $scrapper_configs, $single_config;

$dealership = isset($_GET['dealership']) ? $_GET['dealership']: null;
$make       = isset($_GET['make']) ? $_GET['make']            : null;
$model      = isset($_GET['model']) ? $_GET['model']          : null;
$year       = isset($_GET['year']) ? $_GET['year']            : null;

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (empty($dealership)) {
	$response = [];
	$response['success'] = false;
	$response['message'] = "No dealership specified";
	echo json_encode($response);
	exit;
}

if (empty($make)) {
	$response = [];
	$response['success'] = false;
	$response['message'] = "No make specified";
	echo json_encode($response);
	exit;
}

if (empty($model)) {
	$response = [];
	$response['success'] = false;
	$response['message'] = "No model specified";
	echo json_encode($response);
	exit;
}

if (empty($year)) {
	$response = [];
	$response['success'] = false;
	$response['message'] = "No year specified";
	echo json_encode($response);
	exit;
}
$single_config = $dealership;

require_once $base_path . '/constants.php';
require_once ADWORDS_DIR . '/config.php';
require_once ADWORDS_DIR . '/db_connect.php';
require_once ADWORDS_DIR . '/tag_db_connect.php';


$response = [
	'success' => false,
	'data' => [
		'conversionId' => null,
		'conversionLebel' => null,
	]
];

$data = retrive_tag($cron_name, $year, $make, $model);

if ($data) {
	$response['success']                 = true;
	$response['data']['conversionId']    = $data['conversion_id'];
	$response['data']['conversionLabel'] = $data['label'];
} else {
}

echo json_encode($response);
