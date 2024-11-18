<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

//ini_set('max_execution_time', 0);
//ini_set('display_errors', 0);
//error_reporting(E_ALL);
error_reporting(0);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $CronConfigs;

$cron= isset($_GET['dealership']) ? $_GET['dealership'] : false;

if(!$cron){
	die('Cron Not Exist!!');
}


$data = [];
$table = $cron.'_scrapped_data';
$db_connect  = new DbConnect();

///////////////// Year ////////////////////
$year_data = $db_connect->query("SELECT DISTINCT year FROM $table where deleted=0");
$year=[];
while ($row = mysqli_fetch_assoc($year_data)) {
	$y = trim($row['year']);
	if (!empty($y)) {
		array_push( $year,$y);
	}
}
rsort($year);
$data['year'] = $year;

///////////////// Stock Type ////////////////////
$stock_type_data = $db_connect->query("SELECT DISTINCT stock_type FROM $table where deleted=0");
$stock_type=[];
while ($row = mysqli_fetch_assoc($stock_type_data)) {
	$s = trim($row['stock_type']);
	if (!empty($s)) {
		array_push( $stock_type,$s);
	}
}
sort($stock_type);
$data['stock_type'] = $stock_type;

///////////////// Make ////////////////////
$make_data = $db_connect->query("SELECT DISTINCT make FROM $table where deleted=0");
$make=[];
while ($row = mysqli_fetch_assoc($make_data)) {
	$ma = trim($row['make']);
	if (!empty($ma)) {
		array_push( $make,$ma);
	}
}
sort($make);
$data['make'] = $make;

/////////////////// Model //////////////////
$model_data = $db_connect->query("SELECT DISTINCT model FROM $table where deleted=0");
$model=[];
while ($row = mysqli_fetch_assoc($model_data)) {
	$mo = trim($row['model']);
	if (!empty($mo)) {
		array_push( $model,$mo);
	}
}
sort($model);
$data['model'] = $model;

///////////////////// Car //////////////////////////////
$car_data = $db_connect->query("SELECT `svin`,`stock_number`,`vin`,`stock_type`,`title`,`year`,`make`,`model`,`trim`,`price`,`body_style`,`kilometres`,`url`,`currency`,`all_images` FROM $table WHERE `deleted`=0");
$car=[];
while ($row = mysqli_fetch_assoc($car_data)) {
//	$car[$row['svin']] = $row;
	array_push( $car,$row);
}

$data['car'] = $car;



///////////////// Final /////////////////////
echo json_encode($data);

