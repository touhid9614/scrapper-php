<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$log_path    = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $smedia_website_providers, $smedia_trade_providers, $smedia_carchat_providers, $smedia_other_providers;

global $proxy_list;

$gubagoo = '/.*gubagoo.*/i';

$marketcheck_table = "marketcheck_dealers_v2";

$start_id = isset($_GET['start_id']) ? intval(filter_input(INPUT_GET, 'start_id')) : false;
$limit    = isset($_GET['limit']) ? intval(filter_input(INPUT_GET, 'limit')) : false;

if (isset($argv)) {
    $arguments = $argv[1];
    $output    = explode(":", $arguments, 3);
    $start_id  = intval($output[0]);
    $limit     = intval($output[1]);
    $instance  = intval($output[2]);
    $log_path  = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2_{$instance}.log";
    writeLog($log_path, "Received {$start_id}, {$limit} & {$instance} as arguments for gubagoo.");
}

$db_connect = new DbConnect('');
$existing   = [];
$query      = "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (gubagoo IS NULL) ORDER BY dealer_id ASC;";

if ($start_id) {
    $query = "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (gubagoo IS NULL AND dealer_id >= {$start_id}) ORDER BY dealer_id ASC;";
}

if ($limit) {
    $query = "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (gubagoo IS NULL) ORDER BY dealer_id ASC LIMIT {$limit};";
}

if ($start_id && $limit) {
    $query = "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (gubagoo IS NULL AND dealer_id >= {$start_id}) ORDER BY dealer_id ASC LIMIT {$limit};";
}

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $existing[$row['dealer_id']] = 'https://www.' . $row['inventory_url'];
}

foreach ($existing as $id => $inventory_url) {
    $root_reponse = HttpGet($inventory_url, true, true);

    if (preg_match($gubagoo, $root_reponse)) {
        $vendor_query = "gubagoo = 'YES'";
    } else {
        $vendor_query = "gubagoo = 'NO'";
    }

    $query = "UPDATE {$marketcheck_table} SET {$vendor_query} WHERE dealer_id = {$id};";
    $db_connect->query($query);
    writeLog($log_path, $query);
}

$db_connect->close_connection();