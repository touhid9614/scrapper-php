<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $connection;

$keys = array_keys($CronConfigs);

$dealership = filter_input(INPUT_GET, 'dealership');

if(!in_array($dealership, $keys)) { die(); }

$query = "SELECT smart_offer_customers.uuid, name,email, phone, at FROM smart_offer_customer_fillups, smart_offer_customers WHERE dealership = '$dealership' and smart_offer_customer_fillups.uuid = smart_offer_customers.uuid";

$db_connect = new DbConnect($cron_name);

$res = $db_connect->query($query);

header('Content-Type: text/csv; charset=utf-8');
header("Content-disposition: attachment; filename=\"" . $dealership . "_leads.csv\"");

write_result(['Name', 'Email', 'Phone', 'At', 'URL', 'Referrer', 'Client IP']);

while ($fillup = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $uuid = $fillup['uuid'];
    $url_query = $db_connect->query("SELECT GROUP_CONCAT(url) as url, GROUP_CONCAT(referrer) as referrer, GROUP_CONCAT(client_ip) as client_ip FROM smart_offer_customers_fillups_data WHERE uuid = '$uuid' AND dealership = '$dealership'");
    $url_data = mysqli_fetch_assoc($url_query);
    $fillup['url'] = str_replace(",", "\n", $url_data['url']);
    $fillup['referrer'] = str_replace(",", "\n", $url_data['referrer']);
    $fillup['client_ip'] = str_replace(",", "\n", $url_data['client_ip']);
    unset($fillup['uuid']);
    $fillup['at'] = date('m/d/Y', max(unserialize($fillup['at'])));
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