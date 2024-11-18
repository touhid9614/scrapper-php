<?php

$adwords_dir = dirname(__DIR__) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $CronConfigs;

$cron_name   = filter_input(INPUT_GET, 'dealership');
$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

if (!$cron_config) {
	die(json_encode(array("response" => "Error: No Such Dealership")));
}

#Fillups
$fillups = dealership_get_offers($cron_name);
$begining = strtotime('1 May 2017');
$end      = strtotime('1 June 2017');

echo "<pre>";

foreach ($fillups as $fillup) {

    foreach ($fillup['at'] as $at) {
        if ($at >= $begining && $at < $end) {
            print_r($fillup);
            break;
        }
    }

}

echo "</pre>";
