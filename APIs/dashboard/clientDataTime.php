<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

/* SMEDIA DIRECTORY MAPPING */
$base_dir = dirname(dirname(__DIR__));
require_once $base_dir . '/vendor/autoload.php';

$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $CronConfigs, $scrapper_configs;

$CSV_DIR = "{$adwords_dir}/client-data/";

$scan_put = scan_dir($CSV_DIR);
$fileList = $scan_put['files'];
$response = [];

foreach ($fileList as $file) {
	if (endsiWith($file, '.csv')) {
		$response[fileNameChange($file)] = date('D, d-M-Y H:i:s', filemtime($file));
    }
}

echo json_encode(['files' => $response, 'success' => true]);

function fileNameChange($file) {
	return str_replace('/var/www/html/tm.smedia.ca', 'https://tm.smedia.ca', $file);
}