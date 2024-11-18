<?php

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';

$db_connect = new DbConnect('');

$marketcheck_trade = dirname(__DIR__) . '/reports/s_trade_marketcheck.csv';
//$csv_full = str_getcsv(file_get_contents($marketcheck_trade));
$final = [];
//$len = count($csv_full) / 10;

/*for ($i = 1; $i < 10; $i++)
{
//$final[$csv_full[10*$i+1]] = $csv_full[10*$i+10];
echo $csv_full[10*$i+1];
//echo
}*/

//echo '<pre>';
//print_r($csv_full);
//print_r($final);
//
//echo $csv[10];

/* Map Rows and Loop Through Them */
$rows   = array_map('str_getcsv', file($marketcheck_trade));
$header = array_shift($rows);
$csv    = [];

foreach ($rows as $row) {
    $csv[] = array_combine($header, $row);
}

foreach ($csv as $key) {
    $prepared_key = $db_connect->prepare_query_params($key, PREPARE_PARENTHESES);
    $db_connect->query("INSERT INTO s_trade_competetor $prepared_key");
}
