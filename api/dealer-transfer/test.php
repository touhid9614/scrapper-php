<?php

echo '<pre>';

ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'reporting';

require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'Google/Types.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/SessionManager.php';

$my_debug = filter_input(INPUT_GET, 'my_debug') == '1';

$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';

$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

$analytics = new Analytics('reporting', true);
echo "<br>Analytics : <br>";
print_r($analytics);

$profile_id = '194421174';

$sdate = '2021-01-01';
$date  = new DateTime($sdate);
$edate = $date->format('Y-m-t');

$report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:sessions', 'ga:adClicks'), array('ga:keyword'));

echo "<br>Report<br>";
print_r($report);