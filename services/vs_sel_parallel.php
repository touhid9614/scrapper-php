<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$log_dir     = "{$adwords_dir}/caches/VS/selenium_log";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

$db_connect = new DbConnect('');

$fetch = $db_connect->query("SELECT dealership FROM dealerships WHERE scrapper_type = 'VS' AND status IN ('active', 'trial');");

$dealerships = [];

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealerships[] = $row['dealership'];
}

shuffle($dealerships);

$php_binary = 'php';
exec("ps aux |  grep -i php | grep vs_selenium.php | grep -v grep | awk '{print $2}' | xargs kill");
$worker_list = explode("\n", `ps aux |  grep -i php | grep vs_selenium.php | grep -v grep | awk '{print $2, $13, $3, $10, $8}'`);

$count = 0;

foreach ($dealerships as $dealership) {
    $file     = "{$base_dir}/services/vs_selenium.php";
    $customer = 'marshal';
    $outputr  = [];
    $return   = null;
    $log_path = "{$log_dir}/{$dealership}.log";

    $launch_str = $php_binary . ' '
    . escapeshellarg($file) . ' '
    . escapeshellarg($dealership) . ' '
    . escapeshellarg($customer)
    . ' > /dev/null 2>/dev/null &';

    $sts = exec($launch_str, $outputr, $return);

    if (++$count == 5) {
        $count = 0;
        sleep(600);
    }
}
