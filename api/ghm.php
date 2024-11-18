<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'utils.php';

$cache_file_api = $adwords_dir . 'caches/api-data/';

$action = filter_input(INPUT_POST, 'act');

switch ($action) {
	case 'get-delaerships':
		$query = DbConnect::get_instance()->query("SELECT dealership, company_name FROM dealerships WHERE status='active'");
		$result_data = [];
		$i = 0;
		while ($record = mysqli_fetch_assoc($query)) {
			$result_data[$i]['dealership'] = $record['dealership'];
			$result_data[$i]['company_name'] = $record['company_name'];
			$i++;
		}
		echo json_encode(['message' => 'Action:get-delaerships', 'success' => true, 'data' => $result_data]);
		break;

	case 'vehicle-models':
		$model_cache_file = $cache_file_api . 'model_data.txt';
		$fileContents = json_decode(file_get_contents($model_cache_file), true);
		echo json_encode(['message' => 'Action:vehicle-models', 'success' => true, 'data' => $fileContents]);
		break;

	case 'cars-by-dealer':
		$dealership = filter_input(INPUT_POST, 'dealership');
		if (empty($dealership)) {
			echo json_encode(['message' => $dealership, 'success' => false]);
		} else {
			$check_table_exist = DbConnect::get_instance()->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME = '{$dealership}_scrapped_data'");
			$cars_data = [];
			if (mysqli_num_rows($check_table_exist)) {
				$get_info = DbConnect::get_instance()->query("SELECT * FROM {$dealership}_scrapped_data");
				while ($car = mysqli_fetch_assoc($get_info)) {
					$car['all_images'] = explode('|', $car['all_images']);
					$cars_data[] = $car;
				}
			}
			echo json_encode(['message' => 'Action:cars-by-dealer', 'success' => true, 'data' => $cars_data]);
		}
		break;

	case 'all-vehicle':
		$allcar_cache_file = $cache_file_api . 'allcar_data.txt';
		$fileContents = json_decode(file_get_contents($allcar_cache_file), true);
		echo json_encode(['message' => 'Action:all-vehicle', 'success' => true, 'data' => $fileContents]);
		break;

	case 'cheapest-cars':
		$cheapest_cars_cache_file = $cache_file_api . 'cheapest_cars.txt';
		$fileContents = json_decode(file_get_contents($cheapest_cars_cache_file), true);
		echo json_encode(['message' => 'Action:cheapest-cars', 'success' => true, 'data' => $fileContents]);
		break;

	case 'expensive-cars':
		$expensive_cars_cache_file = $cache_file_api . 'expensive_cars.txt';
		$fileContents = json_decode(file_get_contents($expensive_cars_cache_file), true);
		echo json_encode(['message' => 'Action:expensive-cars', 'success' => true, 'data' => $fileContents]);
		break;
		
	default:
		echo json_encode(['message' => 'No Such Action', 'success' => false]);
		break;
}
