<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$adwords_dir = dirname(__DIR__) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$price 			= urldecode(filter_input(INPUT_POST, 'price'));
$action 		= filter_input(INPUT_POST, 'act');
$URL 			= urldecode(filter_input(INPUT_POST, 'url'));
$dealership 	= getDomainDealer(GetDomain($URL), $URL);
$folder_URL 	= $adwords_dir . 'caches/VS/improper_price_log/' . $dealership . '/';

if (!is_dir($folder_URL)) {
	mkdir($folder_URL, 0755, true);
}

$log_URL 		= $folder_URL . date('Y-m-d') . '.txt';
$log_data 		= date('Y-m-d H:i:s T') . '    ' . $URL . '    ' . $price . "\n";	// date("jS F Y h:i:s T P, l")
$myfile 		= fopen($log_URL, "a+");
fwrite($myfile, $log_data);
echo json_encode(['message' => 'Improper price found!', 'success' => true, 'action' => $action]);
fclose($myfile);