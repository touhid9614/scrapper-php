<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';

$running = exec("ps aux |  grep -i php | grep tradesmart_test.php | grep -v grep | wc -l");

if ($running >= 1) {
    echo json_encode(['message' => 'Tradesmart daily test is currently running.', 'running' => true]);
} else {
    echo json_encode(['message' => 'Tradesmart daily test is not running now.', 'running' => false]);
}