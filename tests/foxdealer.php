<?php

$base_dir    = dirname(__DIR__) . '/';
$adwords_dir = $base_dir . 'adwords3/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$CSV        = $base_dir . 'reports/foxdealer.csv';
$db_connect = new DbConnect('');
$fetch      = $db_connect->query("SELECT dealership, websites FROM dealerships WHERE status IN ('active', 'trial')");

$dealers = [];

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealers[trim(strtolower($row['dealership']))] = trim(strtolower($row['websites']));
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

natcasesort($dealers);

$reg = '/foxdealer\.com/';

$outstream = fopen($CSV, 'w+');
fputcsv($outstream, ['Dealership', 'Website', 'Report']);

foreach ($dealers as $dealership => $websites) {
    $data = HttpGet($websites);

    if (preg_match($reg, $data)) {
        fputcsv($outstream, [$dealership, $websites, 'Foxdealer exists']);
    }
}

fclose($outstream);
