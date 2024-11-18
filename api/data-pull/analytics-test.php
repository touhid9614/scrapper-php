<?php
$my_debug = filter_input(INPUT_GET, 'my_debug') == '1';

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use sMedia\Analytics\Analytics;

echo "<pre>";

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';
require_once ADSYNCPATH . 'utils.php';

echo "<br><br>===================================<br><br>";

$analytics = new Analytics('marshalsmedia');

if ($my_debug) {
    echo "<br>Analytics : <br>";
    print_r($analytics);
}

$analytics_account = $analytics->GetAccountSummaries();

print_r($analytics_account);

echo "<br><br>===================================<br><br>";

$analytics = new Analytics('smediaanalytic');

if ($my_debug) {
    echo "<br>Analytics : <br>";
    print_r($analytics);
}

$analytics_account = $analytics->GetAccountSummaries();

print_r($analytics_account);

echo "<br><br>===================================<br><br>";

$analytics = new Analytics('smediawebmastertool');

if ($my_debug) {
    echo "<br>Analytics : <br>";
    print_r($analytics);
}

$analytics_account = $analytics->GetAccountSummaries();

print_r($analytics_account);

echo "<br><br>===================================<br><br>";

$analytics = new Analytics('smediaanalytic2');

if ($my_debug) {
    echo "<br>Analytics : <br>";
    print_r($analytics);
}

$analytics_account = $analytics->GetAccountSummaries();

print_r($analytics_account);

echo "<br><br>===================================<br><br>";

$analytics = new Analytics('coaganalytics');

if ($my_debug) {
    echo "<br>Analytics : <br>";
    print_r($analytics);
}

$analytics_account = $analytics->GetAccountSummaries();

print_r($analytics_account);

echo "<br><br>===================================<br><br>";

exit();

$profile_id = '178320776';

$sdate = '2021-01-01';
$date  = new DateTime($sdate);
$edate = $date->format('Y-m-t');

$report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration'), array('ga:sourceMedium', 'ga:campaign'));

echo "<br>Report<br>";
print_r($report);