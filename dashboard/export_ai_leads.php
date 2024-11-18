<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $connection;

$keys = array_keys($CronConfigs);

$dealership = filter_input(INPUT_GET, 'dealership');
$date_range = filter_input(INPUT_GET, 'date_range');
$start_date = filter_input(INPUT_GET, 'start_date');
$end_date = filter_input(INPUT_GET, 'end_date');

if (empty($date_range)) {
    $date_range = 'all_time';
}

if (!in_array($dealership, $keys)) {
    die();
}

$db_connect = new DbConnect($cron_name);



header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=\"" . $dealership . "_leads.csv\"");

//write_result(['Name', 'Email', 'Phone', 'At']);


$header = [
    'company_name',
    'company_email',
    'stock_type',
    'stock_number',
    'year',
    'make',
    'model',
    'price',
    'fdt',
    'first_name',
    'last_name',
    'email',
    'phone',
    'comments',
    'address',
    'dob_month',
    'dob_day',
    'dob_year',
    'vehicle_use',
    'living',
    'living_since',
    'mortgage_payment',
    'marital_status',
    'appointment_date',
    'trade_year',
    'trade_make',
    'trade_model',
    'considering-tradein',
    'qualify-gm-pricing',
    'url',
    'button_text',
    'button_name',
    'no-marketing',
    'marketing-consent',
    'referrer',
    'client_ip',
    'at'
];
echo implode(",", $header) . "\n";

if ($date_range == 'all_time') {
    $query = "SELECT params,at FROM `leads_ai_dealerships` where dealership = '$dealership'";
} else {
    $date1 = new DateTime($start_date);
    $date2 = new DateTime($end_date);
    $query = "SELECT params,at FROM `leads_ai_dealerships` where dealership = '$dealership' AND at BETWEEN '$start_date' AND '$end_date'";
}

$res = $db_connect->query($query);
while ($fillup = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $at         =   $fillup['at'];
    $out        =  unserialize($fillup['params']);
    $out['at']  =     $fillup['at'];
    write_result($out,$header);
}

mysqli_free_result($res);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

function write_result($data,$header) {
    foreach ($header as  $head) {
        echo empty($data[$head])? ',': str_replace(',','-',$data[$head]).',';
    }
    echo "\n";
}
