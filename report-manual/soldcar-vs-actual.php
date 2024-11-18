<?php
$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'utils.php';
$dealership = filter_input(INPUT_GET, 'dealership');
$csv_url = filter_input(INPUT_GET, 'csv_url');

//http://tm-dev.smedia.ca/report-manual/soldcar-vs-actual.php?dealership=knightnissan&csv_url=http://tm-dev.smedia.ca/adwords3/caches/Knight%20Nissan.csv

header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=\"" . $dealership . "_soldcar_vs_actual.csv\"");

$resp = HttpGet($csv_url);
$decode_resp = csv_real_decode($resp);
$actual_solds = [];
foreach ($decode_resp as $record) {
    $stock_number = trim($record['VehicleStockNumber']);
    $actual_solds[$stock_number]['title'] = $record['VehicleYear'] . ' ' . $record['VehicleMake'] . ' ' . $record['VehicleModel'];
    $actual_solds[$stock_number]['sold_date'] = $record['SoldDate'];
}

$db_sold_car = [];
$get_allcar = DbConnect::get_instance()->query("SELECT * FROM {$dealership}_scrapped_data WHERE deleted = '1'");
while ($car = mysqli_fetch_assoc($get_allcar)) {
    $db_sold_car[$car['stock_number']]['title'] = $car['year'] . ' ' . $car['make'] . ' ' . $car['model'];
    $db_sold_car[$car['stock_number']]['sold_date'] = date('d/m/Y', $car['updated_at']);
}

$final_data = ['Stock Number', 'Title', 'Sold Date', 'DB Sold Date', 'Day Difference', 'Status'];
echo implode("," , $final_data) . "\n";  

foreach ($actual_solds as $stock_number => $car) {
    $final_data = [];
    $final_data['stock_number'] = $stock_number;
    $final_data['title'] = $car['title'];
    $final_data['sold_date'] = $car['sold_date'];
    $db_sold_date = isset($db_sold_car[$stock_number]) ? $db_sold_car[$stock_number]['sold_date'] : '';  
    $sold_date = str_replace('-', '/', substr($car['sold_date'], 0,9));
    $final_data['db_sold_date'] = $db_sold_date;   
    
    $final_data['diff_day'] =   'N/A';
    if($db_sold_date && $sold_date) {
        $diff_day   = (((strtotime($sold_date) - strtotime($db_sold_date)) / 3600) / 24);     
        $final_data['diff_day'] = $diff_day;
    }
    
    if($sold_date == $db_sold_date) {
       $status = 'OK'; 
    } else {
        $status = 'NOT OK';
    }
    $final_data['status'] = $status;
    echo implode("," , $final_data) . "\n";  
}




