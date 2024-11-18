<?php

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $proxy_list, $CronConfigs;

$crons = array_keys($CronConfigs);

$db_connect = new DbConnect('');

$fetch = $db_connect->query("SELECT dealership, websites FROM dealerships WHERE (status = 'active' OR status = 'trial');");

$dealers = [];

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealers[$row['dealership']] = trim($row['websites']) . '?cache_reset=true&smedia_debug=true';
}

foreach ($dealers as $dealership => $url) {
    $response = HttpGet($url, $proxy_list);

    if (!$response) {
        echo $url . '<br>';
    }

}
