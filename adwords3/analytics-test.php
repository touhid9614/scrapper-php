<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';
$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';

$cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : 'titanauto';
$proId     = isset($_GET['proId']) ? $_GET['proId'] : '';

$result = [];
echo '<pre>';

echo "Cron_name: $cron_name<br>";
$domain = getDealerDomain($cron_name);
echo "Domain: $domain <br>";

echo "==================<br>";
echo "<br> Current Config <br>";
print_r($CurrentConfig);
echo "==================<br>";

$analytics = new Analytics(get_current_google_customer());
echo "<br>Analytics <br>";
print_r($analytics);
echo "==================<br>";

$data = $analytics->GetHostSummary($domain);

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

$key_array_sum = ['users', 'newUser', 'sessions', 'bounceRate', 'pagesPerSession', 'avgSessionDuration', 'engagedProspects', 'epConvRate'];
foreach ($key_array_sum as $index) {
    $total[$index] = 0;
}

$sdate  = isset($_GET['month']) ? $_GET['month'] : '2020-08-01';
$date   = new DateTime($sdate);
$edate  = $date->format('Y-m-t');
$report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration', 'ga:pageviews'), array('ga:sourceMedium', 'ga:campaign'));
echo "Report : <br>";
print_r($report);
$finalData = [];
if (!$report || !$report->rows) {
    echo '<br>No Row Found <br>';
} else {
    foreach ($report->rows as $row) {
        $dataArray                       = [];
        $dataArray['sourceMedium']       = $row[0];
        $dataArray['campaign']           = $row[1];
        $dataArray['users']              = $row[2];
        $dataArray['newUser']            = $row[3];
        $dataArray['sessions']           = $row[4];
        $dataArray['bounceRate']         = $row[5];
        $dataArray['pagesPerSession']    = $row[6];
        $dataArray['avgSessionDuration'] = gmdate("H:i:s", $row[7]);

        $finalData[] = $dataArray;

        $total['users'] += $row[2];
        $total['newUser'] += $row[3];
        $total['sessions'] += $row[4];
        $total['bounceRate'] += $row[5];
        $total['pagesPerSession'] += $row[6];
        $total['avgSessionDuration'] += $row[7];

    }

    echo "==================<br>";
    echo "==================<br>";

    $report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:sessions'), array('ga:sourceMedium', 'ga:campaign', 'ga:eventCategory'));
    echo "Report of engaged Prospects  : <br>";
    print_r($report);
    if (!$report || !$report->rows) {
        echo '<br>No Row Found for engaged Prospects <br>';
    } else {
        foreach ($report->rows as $row) {
            if ($row[2] == "Profitable Engagement") {
                foreach ($finalData as $key => $item) {
                    if ($item['sourceMedium'] == $row[0] && $item['campaign'] == $row[1]) {
                        $finalData[$key]['engagedProspects'] = $row[3];
                        $finalData[$key]['epConvRate']       = ($finalData[$key]['engagedProspects'] / $finalData[$key]['sessions']) * 100;

                        $total['engagedProspects'] += $row[3];
                        $total['epConvRate'] += $finalData[$key]['epConvRate'];
                    }
                }
            }
        }
    }

}

echo "==================<br>";
echo "++++++++++++++++++++++<br>";
echo "==================<br>";

print_r($finalData);

echo "==================<br>";
echo "++++++++++++++++++++++<br>";
echo "==================<br>";

$countFinal                  = count($finalData);
$total['avgSessionDuration'] = gmdate("H:i:s", ($total['avgSessionDuration'] / $countFinal));
$total['bounceRate']         = $total['bounceRate'] / $countFinal;
$total['pagesPerSession']    = $total['pagesPerSession'] / $countFinal;
$total['epConvRate']         = $total['epConvRate'] / $countFinal;

print_r($total);

echo "++++++++++++++++++++++<br>";
$id = isset($_GET['id']) ? $_GET['id'] : '5df1e2e77c0f1f7df41c31e1';

echo "=======================================";
//$account = $analytics->GetAccounts();
//print_r($account);
$myObj                 = [];
$myObj['dealerId']     = $id;
$myObj['key']          = "analytic";
$myObj['data']['date'] = $sdate;
$myObj['data']['data'] = $finalData;
// $myObj->data = $finalData;
$post_data                         = json_encode($myObj);
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1/social-data' : 'https://api-qa.smedia.ca/v1/social-data';
//$res = HttpPost($post_url, $post_data, '', $nothing, false, false, 'application/json',$additional_headers);
print_r($post_data);
echo "<br>===================<br>";
//print_r($res);
