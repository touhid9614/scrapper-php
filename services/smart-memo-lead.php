<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$adwords_dir = dirname(__DIR__) . "/adwords3/";

global $CronConfigs, $single_config;

$single_config = filter_input(INPUT_POST, 'dealership');

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'uuid.php';

$debug           = filter_input(INPUT_GET, 'debug') == 'true';
$action          = filter_input(INPUT_POST, 'act');
$cron_name       = filter_input(INPUT_POST, 'dealership');
$url             = filter_input(INPUT_POST, 'url');
$user_unique_id  = filter_input(INPUT_POST, 'smedia_smart_lead_uuid');
$session_id      = filter_input(INPUT_POST, 'session_id');
$mongo_dealer_id = filter_input(INPUT_POST, 'mongo_dealer_id');
$svin            = filter_input(INPUT_POST, 'svin');
$client_ip       = DbConnect::get_instance()->get_client_ip();

$post_url = 'https://api.smedia.ca/v1';
$date     = date('Ymd');

// Identifyable uuid
if (!$user_unique_id || strlen($user_unique_id) < 64) {
    $user_unique_id = UUID::v4();
}

try {
    if ($user_unique_id) {
		if ($mongo_dealer_id && strlen($mongo_dealer_id) == 24) {
            $myObj            = [];
            $myObj['date']    = $date;
            $myObj['action']  = $action;
            $myObj['service'] = "smart-memo";
            $myObj['uuid']    = $user_unique_id;
            $myObj['session'] = $session_id;
            $myObj['url']     = $url;
            $myObj['svin']    = $svin;
            $myObj['ip']      = $client_ip;

            if ($debug) {
                $myObj['debug'] = true;
            }

            $post_data          = json_encode($myObj);
            $post_url_data_push = "{$post_url}/smart-memo/{$mongo_dealer_id}";
            HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
        }

        echo json_encode(['response' => "Smart Memo view is recorded for '{$user_unique_id}'", "error" => false]);
    } else {
        echo json_encode(['response' => false, "error" => "Invalid user unique ID '{$user_unique_id}'"]);
    }
} catch (Exception $ex) {
    echo json_encode(['response' => false, "error" => $ex->getMessage()]);
}
