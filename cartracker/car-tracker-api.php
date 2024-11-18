<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// SMEDIA DIRECTORY MAPPING
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

// INCLUDE REQUIRED FILES
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

// Call car tracker class
require_once "car_tracker.php";

$dealership = filter_input(INPUT_GET, 'dealership');
$start_date = filter_input(INPUT_GET, 'start_date');
$end_date   = filter_input(INPUT_GET, 'end_date');

if (!$dealership) {
	die('Dealership name required');
}

if (!$start_date) {
	die('Start date required');
}

if (!$end_date) {
	die('End date required');
}

$db_connect  = new DbConnect($dealership);
$car_tracker = new CarTracker();

echo json_encode($car_tracker->generateSaleReport($dealership, $start_date, $end_date, $db_connect));