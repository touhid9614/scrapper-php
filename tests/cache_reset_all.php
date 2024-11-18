<?php

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $proxy_list, $CronConfigs;

$crons      = array_keys($CronConfigs);
$db_connect = new DbConnect('');
$fetch      = $db_connect->query("SELECT dealership FROM dealerships WHERE (status = 'active' OR status = 'trial');");
$dealers    = [];

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealers[] = $row['dealership'] . "_scrapped_data";
}

$i = 0;
foreach ($dealers as $table) {
    $j         = 0;
    $query     = "SELECT url FROM {$table} WHERE deleted = false;";
    $fetch_url = $db_connect->query($query);

    while ($row = mysqli_fetch_assoc($fetch_url)) {
        $url = $row['url'] . "?cache_reset=true&smedia_debug=true";
        HttpGet($url, $proxy_list);
        echo $i . " " . $j . " " . $url . "<br>";
        $i++;
        $j++;
    }
}
