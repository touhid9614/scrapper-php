<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$base_dir = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'utils.php';

// $cache_file_cardata = $adwords_dir . 'caches/api-data/allcar_data.txt';


$query = DbConnect::get_instance()->query("SELECT dealership FROM dealerships WHERE status='active'");
$model_data = [];
$cheapest_cars = [];
$expensive_cars = [];

$log_file = $adwords_dir . 'caches/api-data/log_data.txt';
$fopen_log = fopen($log_file, "a");
fwrite($fopen_log, "\n");
fwrite($fopen_log, "DATE TIME: " . date('Y-m-d H:i:s'));
fwrite($fopen_log, "\n");

// $final_cars_data = [];
// read the file if present
// $all_car_fop = fopen($cache_file_cardata, 'w');

while ($dealership = mysqli_fetch_assoc($query)) {
    $all_cars_data = [];
    // Get only distince model of this dealer car
    // Check dealership scrapped_data table exist or not
    $check_table_exist = DbConnect::get_instance()->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME = '{$dealership['dealership']}_scrapped_data'");

	if (mysqli_num_rows($check_table_exist)) {
        // Get all cars data from all active dealer
        $get_allcar = DbConnect::get_instance()->query("SELECT DISTINCT(model) as model FROM {$dealership['dealership']}_scrapped_data");
        while ($car = mysqli_fetch_assoc($get_allcar)) {
            $model_data[] = $car['model'];

            // $car['all_images'] = explode('|', $car['all_images']);
            // seek to the end
            /*fseek($all_car_fop, 0, SEEK_END);
              fwrite($all_car_fop, ',');
              fwrite($all_car_fop, json_encode($car, JSON_PRETTY_PRINT)); */
        }

        $get_cheapcar = DbConnect::get_instance()->query("SELECT MIN(price) as min_price, {$dealership['dealership']}_scrapped_data.*  FROM {$dealership['dealership']}_scrapped_data WHERE deleted = 0");
        while ($cheap_car = mysqli_fetch_assoc($get_cheapcar)) {
            unset($cheap_car['min_price']);
            $cheap_car['dealership'] = $dealership['dealership'];
            $cheapest_cars[] = $cheap_car;
        }

        $get_expcar = DbConnect::get_instance()->query("SELECT MAX(price) as max_price, {$dealership['dealership']}_scrapped_data.*  FROM {$dealership['dealership']}_scrapped_data WHERE deleted = 0");

		while ($exp_car = mysqli_fetch_assoc($get_expcar)) {
            unset($exp_car['max_price']);
            $exp_car['dealership'] = $dealership['dealership'];
            $expensive_cars[] = $exp_car;
        }

        fwrite($fopen_log, $dealership['dealership']);
        fwrite($fopen_log, "\n");
    }
}
fclose($fopen_log);

/*
  fseek($all_car_fop, 0);
  fwrite($all_car_fop, '[');
  fseek($all_car_fop, 0, SEEK_END);
  fwrite($all_car_fop, ']');
  fclose($all_car_fop); */

$model_data = array_unique($model_data);
$cache_file_modeldata = $adwords_dir . 'caches/api-data/model_data.txt';
file_put_contents($cache_file_modeldata, json_encode($model_data, JSON_PRETTY_PRINT));

file_put_contents($adwords_dir . 'caches/api-data/cheapest_cars.txt', json_encode($cheapest_cars, JSON_PRETTY_PRINT));
file_put_contents($adwords_dir . 'caches/api-data/expensive_cars.txt', json_encode($expensive_cars, JSON_PRETTY_PRINT));
