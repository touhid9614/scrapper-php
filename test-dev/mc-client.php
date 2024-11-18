<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');
$key        = '1rzzZhML7WeDkmGVu66au43fBG9Np5Vw';
$base       = 'https://marketcheck-prod.apigee.net/v2';
$table      = "marketcheck_temp";

$arguments = $argv[1];
$output    = explode(":", $arguments, 3);
$start_id  = intval($output[0]);
$end_id    = intval($output[1]);
$instance  = intval($output[2]);

$log_file = "{$adwords_dir}/caches/marketcheck-test/mc_client_{$instance}.log";
writeLog($log_file, "Received {$start_id}, {$end_id} & {$instance} as arguments for mc-client.");

for ($id = $start_id; $id < $end_id; $id++) {
    $active_api = "{$base}/car/dealer/inventory/active?api_key={$key}&dealer_id={$id}";
    $recent_api = "{$base}/search/car/recents?api_key={$key}&dealer_id={$id}";

    $active_data = json_decode(HttpGet($active_api), true);
    $recent_data = json_decode(HttpGet($recent_api), true);

    $active_inventory = isset($active_data['num_found']) ? $active_data['num_found'] : 0;
    $recent_inventory = isset($recent_data['num_found']) ? $recent_data['num_found'] : 0;

    $db_connect->query("UPDATE {$table} SET active_inventory = {$active_inventory}, recent_inventory = {$recent_inventory} WHERE dealer_id = {$id};");
}