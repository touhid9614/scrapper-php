<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';
$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';

$cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : 'crestviewchrysler';
$proId     = isset($_GET['proId']) ? $_GET['proId'] : '';

$result = [];
echo '<pre>';

echo "Cron_name: $cron_name<br>";
$domain = getDealerDomain($cron_name);
echo "Domain: $domain <br>";

$analytics = new Analytics(get_current_google_customer());
$data      = $analytics->GetHostSummary($domain);

if (!$data && !strlen($proId)) {
    echo " No data for profileId <br>";
    exit;
} else {
    $profileId = null;

    if (!strlen($proId)) {

        foreach ($data as $report) {
            $profileName = strtolower($report->profileInfo->profileName);
            if (strpos($profileName, 'smedia') !== false) {
                $profileId = $report->profileInfo->profileId;
                break;
            }
        }

        if (!strlen($profileId)) {
            $pageViews = 0;

            foreach ($data as $report) {
                if ($profileId == null) {
                    $profileId = $report->profileInfo->profileId;
                    $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
                } elseif ($report->totalsForAllResults->{'ga:pageviews'} > $pageViews) {
                    $profileId = $report->profileInfo->profileId;
                    $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
                }
            }
        }

    } else {
        $profileId = $proId;
    }
}
echo "<br>profileId : $profileId <br>";
echo "<br>==================<br>";

$total['pageviews']  = 0;
$total['timeOnPage'] = 0;

$sdate  = isset($_GET['month']) ? $_GET['month'] : '2020-07-01';
$date   = new DateTime($sdate);
$edate  = $date->format('Y-m-t');
$report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:pageviews', 'ga:timeOnPage'), array('ga:sourceMedium'));
echo "Report : <br>";
//print_r($report);
$finalData = [];
if (!$report || !$report->rows) {
    echo '<br>No Row Found <br>';
} else {
    foreach ($report->rows as $row) {
        $dataArray                 = [];
        $dataArray['sourceMedium'] = $row[0];
        $dataArray['pageviews']    = $row[1];
        $dataArray['timeOnPage']   = $row[2];

        $finalData[] = $dataArray;

        $total['pageviews'] += $row[1];
        $total['timeOnPage'] += $row[2];
    }
}

echo "==================<br>";
print_r($finalData);

echo "<br>--------------------------------------<br>";
echo "Total<br>";
print_r($total);