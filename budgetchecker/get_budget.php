<?php

define('noprint', true);

require_once 'config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

require_once '../dashboard/includes/functions.php';
require_once '../dashboard/includes/ajax_inc.php';

require_once ABSPATH . 'includes/ajax_inc.php';

global $set_path, $connection;

set_time_limit(0);
error_reporting(E_ALL);

$total_result  = [];
$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];
$mutex         = Mutex::create();
$dealerships   = get_dealerships();
$count         = 0;

print_r($dealerships); exit();

foreach ($dealerships as $key => $value) {
    $count++;
    $result         = eval_dealership($CurrentConfig, $value, $mutex);
    $total_result[] = $result;
    $myfile         = fopen("budgetchecker_log.txt", "a");
    fwrite($myfile, $value);
    fwrite($myfile, "\n");

    if ($count == 30) {
        break;
    }
}

$encodedString = json_encode($total_result);
file_put_contents('budgetchecker_data.txt', $encodedString);
Mutex::destroy($mutex);