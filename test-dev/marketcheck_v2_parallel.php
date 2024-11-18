<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$db_connect    = new DbConnect('');
$query         = "SELECT dealer_id FROM marketcheck_dealers_v2 WHERE (website_provider IS NULL);";
$result        = $db_connect->query($query);
$dealer_count  = mysqli_num_rows($result);
$dealers       = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dealers[] = $row['dealer_id'];
}

$number_of_process = isset($_GET['process']) ? intval(filter_input(INPUT_GET, 'process')) : 200;
$limit             = ceil($dealer_count / $number_of_process);

$file     = "{$base_dir}/test-dev/marketcheck_v2_provider.php";
$log_path = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2_all.log";

for ($i = 0; $i < $number_of_process; $i++) {
    $outputr   = [];
    $return    = null;
    $start_id  = $dealers[$i * $limit];
    $arguments = "{$start_id}:{$limit}:{$i}";

    $launch_str = 'php '
    . escapeshellarg($file) . ' '
    . escapeshellarg($arguments)
    . ' > /dev/null 2>/dev/null &';

    $sts = exec($launch_str, $outputr, $return);

    $msg = "Created instance no {$i} with limit: {$limit} starting at {$start_id} for website_provider.\n";
    echo $msg . '<br>';
    writeLog($log_path, $msg);
}
