<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $connection;

$keys = array_keys($CronConfigs);

$dealership = filter_input(INPUT_GET, 'dealership');

if(!in_array($dealership, $keys)) { die(); }
$query = "select soc.name, soc.email, soc.phone, socfd.`datetime`,socfd.url,socfd.referrer, socfd.client_ip from smart_offer_customers_fillups_data as socfd left join smart_offer_customers as soc ON soc.uuid=socfd.uuid  WHERE socfd.dealership ='$dealership'";


$db_connect = new DbConnect($cron_name);

$res = $db_connect->query($query);

header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=\"" . $dealership . "_leads.csv\"");

write_result(['Name', 'Email', 'Phone', 'At', 'URL', 'Referrer', 'Client IP']);

while ($fillup = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    write_result($fillup);
}

mysqli_free_result($res);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

function write_result($data) {
    array_walk($data, function(&$value, $index){
        if(stripos($value, ',') !== false || stripos($value, "\n") !== false) {
            $value = "\"$value\"";
        }
    });
    echo implode("," , $data) . "\n";
}
