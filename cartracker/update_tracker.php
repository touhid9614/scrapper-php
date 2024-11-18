<?php

// SMEDIA DIRECTORY MAPPING
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

// INCLUDE REQUIRED FILES
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

// Call car tracker class
require_once "car_tracker.php";

global $scrapper_configs, $CronConfigs;

$dealer_list  = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

$sold_cars  = [];
$vinset     = [];
$stkset     = [];
$urlset     = [];
$result_set = [];

$dealership  = 'aachevy';
$db_connect  = new DbConnect($dealership);
$car_tracker = new CarTracker();

// $car_tracker->getSoldCarDataSet($dealership, $sold_cars, $vinset, $stkset, $urlset, $db_connect);

// print_r($sold_cars);
// print_r($vinset);
// print_r($stkset);
// print_r($urlset);

// print_r($car_tracker->getSaleReportByDay($dealership, '04-Nov-2020', $db_connect));
// print_r($car_tracker->getSaleReportByWeekNoAndMonthAndYear($dealership, 3, 'nov', 2020, $db_connect));
// print_r($car_tracker->getSaleReportByWeekNoAndYear($dealership, 45, 2020, $db_connect));
// print_r($car_tracker->getSaleReportByMonthAndYear($dealership, 'nov', 2020, $db_connect));
// print_r($car_tracker->getSaleReportByYear($dealership, 2020, $db_connect));
// print_r($car_tracker->generateSaleReport($dealership, '01-Dec-2020', '31-Dec-2020', $db_connect));
// print_r($car_tracker->generateReAddReport($dealership, $db_connect));
// print_r($car_tracker->generateReAddOverview($dealer_list, $db_connect));
print_r($car_tracker->generateMonthlySaleCalenderReport($dealership, '12', '2020', $db_connect));