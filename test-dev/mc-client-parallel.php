<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";
$data_dir    = $adwords_dir . '/data/marketcheck/';
$log_file    = $adwords_dir . '/caches/marketcheck-test/parallel.log';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$first = 1000000;
$last  = 1104775;

$number_of_process = 210;
$limit             = 500;

$file = "{$base_dir}/test-dev/mc-client.php";

for ($i = 0; $i < $number_of_process; $i++) {
    $outputr   = [];
    $return    = null;
    $start_id  = $first + $i * $limit;
    $end_id    = $start_id + $limit;
    $arguments = "{$start_id}:{$end_id}:{$i}";

    $launch_str = 'php '
    . escapeshellarg($file) . ' '
    . escapeshellarg($arguments)
    . ' > /dev/null 2>/dev/null &';

    $sts = exec($launch_str, $outputr, $return);

    $msg = "Created instance no {$i} with limit: {$limit} starting at {$start_id} for mc-clinet.\n";
    echo $msg . '<br>';
    writeLog($log_file, $msg);
    sleep(2);
}
