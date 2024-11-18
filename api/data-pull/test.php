<?php

$my_debug = filter_input(INPUT_GET, 'my_debug') == '1';

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use sMedia\Analytics\Analytics;

echo "<pre>";

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';
require_once ADSYNCPATH . 'utils.php';

$profile_id = '178320776';
$account    = 'smediaanalytic';

$sdate = '2021-01-02';
$date  = new DateTime($sdate);
$edate = $date->format('Y-m-t');

$analytics = new Analytics($account);

echo "<br>Analytics : <br>";
print_r($analytics);

$report = $report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration'), array('ga:channelGrouping'));

echo "<br>Report<br>";
print_r($report);