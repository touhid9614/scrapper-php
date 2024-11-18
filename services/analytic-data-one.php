<?php

use Illuminate\Database\Capsule\Manager as DB;

$base_dir = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $base_dir . 'includes/init-db.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';
require_once $adwords_dir . 'Google/Consts.php';
require_once $adwords_dir . 'Google/TokenHelper.php';
require_once $adwords_dir . 'Google/SessionManager.php';
require_once $adwords_dir . 'Google/Analytics.php';

$client = new MongoDB\Client(
	'mongodb://smedia:6Qrt2WPqd4qB3HUvzG@mongo-dev.smedia.ca:27017/smedia_apps?authSource=admin&readPreference=primary&appname=smedia&ssl=false'
);

$db = $client->smedia_apps;


$cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : '';
$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1/social-data' : 'https://api-qa.smedia.ca/v1/social-data';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$allMonth = isset($_GET['month']) ? (($_GET['month'] == "all") ? true : false) : false;
$proId = isset($_GET['proId']) ? $_GET['proId'] : '';

echo '<pre>';

if (!empty($cron_name) && !empty($id)) {
	$dealerships[$cron_name] = $id;
} else {
	$dealerships['crestviewchrysler'] = '5df1e2e77c0f1f7df41c31e2';
	$dealerships['knightnissan'] = '5df1e2e77c0f1f7df41c31e3';
	$dealerships['knightfordlincoln'] = '5df1e2e77c0f1f7df41c31e4';
	$dealerships['knightdodgeofweyburn'] = '5df1e2e77c0f1f7df41c31e5';
	$dealerships['knightdodge'] = '5df1e2e77c0f1f7df41c31e6';
}
//print_r($dealerships);

foreach ($dealerships as $cron_name => $id) {
	$log_file_path = dirname(__DIR__) . '/adwords3/caches/report-log/' . $cron_name . '-analytic.txt';

	echo "Cron_name: $cron_name<br>";
	$domain = getDealerDomain($cron_name);
	echo "Domain: $domain <br>";
	echo "Id: $id <br>";

	writeLog($log_file_path, "***** ***** ***** *****");
	writeLog($log_file_path, "Cron_name: $cron_name");
	writeLog($log_file_path, "Domain: $domain");
	writeLog($log_file_path, "Id: $id");

	if ($domain) {

		$analytics = new Analytics(get_current_google_customer());
		$data = $analytics->GetHostSummary($domain);
		if (!$data && !strlen($proId)) {
			echo " No data for profileId <br>";
			writeLog($log_file_path, "No data for profileId");
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


			echo "<br>profileId : $profileId <br>";
			writeLog($log_file_path, "profileId: $profileId");

			if ($allMonth) {
				$year = ['2019', '2020'];
				$month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
			} else {
				$year = ['2020'];
				$month = ['10', '11', '12'];
			}
			foreach ($year as $y) {
				foreach ($month as $m) {
					$sdate = $y . '-' . $m . '-01';
					$date = new DateTime($sdate);
					$edate = $date->format('Y-m-t');

					$date_now = date("Y-m-d");
					if ($date_now > $sdate) {
						echo "Date : $sdate :: $edate :: $profileId<br>";
						writeLog($log_file_path, "Time- $sdate :: $edate");
						$report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration'), array('ga:sourceMedium', 'ga:campaign'));

						//echo "Report : <br>";
						//print_r($report);

						$finalData = array();
						if (!$report->rows) {
							echo '<br><b>No Data Found </b><br>';
							writeLog($log_file_path, "No Data Found");
						} else {
							foreach ($report->rows as $row) {
								$dataArray = array();
								$dataArray['sourceMedium'] = $row[0];
								$dataArray['campaign'] = $row[1];
								$dataArray['users'] = $row[2];
								$dataArray['newUser'] = $row[3];
								$dataArray['sessions'] = $row[4];
								$dataArray['bounceRate'] = $row[5];
								$dataArray['pagesPerSession'] = $row[6];
								$dataArray['avgSessionDuration'] = gmdate("H:i:s", $row[7]);


								$finalData[] = $dataArray;
							}

							$report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:sessions'), array('ga:sourceMedium', 'ga:campaign', 'ga:eventCategory'));
//							echo "Report of engaged Prospects  : <br>";
//							print_r($report);
							if (!$report || !$report->rows) {
								echo '<br>No Row Found for engaged Prospects <br>';
								writeLog($log_file_path, "No Row Found for engaged Prospects");
							} else {
								foreach ($report->rows as $row) {
									if ($row[2] == "Profitable Engagement") {
										foreach ($finalData as $key => $item) {
											if ($item['sourceMedium'] == $row[0] && $item['campaign'] == $row[1]) {
												$finalData[$key]['engagedProspects'] = $row[3];
												$finalData[$key]['epConvRate'] = ($finalData[$key]['engagedProspects'] / $finalData[$key]['sessions']) * 100;
											}
										}
									}
								}
							}
						}


//                    print_r($finalData);
//                    echo "==============<br>";

						$myObj = array();
						$myObj['dealerId'] = $id;
						$myObj['key'] = "analytic";
						$myObj['data']['date'] = $sdate;
						$myObj['data']['data'] = $finalData;
						// $myObj->data = $finalData;
						$post_data = json_encode($myObj);
						$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


						$res = HttpPost($post_url, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
						print_r($post_data);
						echo "<br>";
						print_r($res);
						writeLog($log_file_path, "Response ::  $res");
						echo "<br>===================<br>";
					}
				}
			}
			echo "<br><br>*************************************** <br><br>";
		}
	} else {
		echo " NO Domain found<br>";
		writeLog($log_file_path, " NO Domain found ");
	}
}


