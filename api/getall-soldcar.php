<?php

$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'utils.php';

header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=allsold_cars.csv");

$table_header = [];
$get_table_header = DbConnect::get_instance()->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'barbermotors_scrapped_data'");

while ($column = mysqli_fetch_assoc($get_table_header)) {
	if (!in_array($column['COLUMN_NAME'], ['all_images'])) {
		$table_header[] = $column['COLUMN_NAME'];
	}
}

echo implode(",", $table_header) . "\n";

$query = DbConnect::get_instance()->query("SELECT dealership FROM dealerships WHERE status='active'");

while ($dealership = mysqli_fetch_assoc($query)) {
	// Get only distince model of this dealer car
	// Check dealership scrapped_data table exist or not
	$check_table_exist = DbConnect::get_instance()->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME = '{$dealership['dealership']}_scrapped_data'");

	if (mysqli_num_rows($check_table_exist)) {
		// Get all cars data from all active dealer
		$get_allcar = DbConnect::get_instance()->query("SELECT * FROM {$dealership['dealership']}_scrapped_data WHERE deleted = '1'");
		while ($car = mysqli_fetch_assoc($get_allcar)) {
			$new_car = [];
			unset($car['all_images']);
			foreach ($car as $car_value) {
				$new_car[] = str_replace(',', '', $car_value);
			}
			echo implode(",", $new_car) . "\n";
		}
	}
}
