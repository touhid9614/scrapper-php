<?php
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require_once $base_path . '/api/dealer-transfer/email.php';

use sMedia\Analytics\Analytics;

global $CronConfigs, $CurrentConfig;

$post_url = (isset($_GET['api']) && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-dev.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';
$skip = isset($_GET['skip']) ? $_GET['skip'] : 0;

echo '<pre>';
echo '<b>' . $post_url . "</b><br>";

$my_debug = filter_input(INPUT_GET, 'my_debug') == '1';
$dealer_cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : '';

$post_url_dealer_id_pull = $post_url . "/dealer-account-id/analytics";
$res = HttpGet($post_url_dealer_id_pull, false, false, '', $nothing, 'application/json', $additional_headers);
$dealerships = json_decode($res);

$date = date('Y-m-d', strtotime("-1 day"));

$current_year = date('Y', strtotime($date));
$current_month = date('m', strtotime($date));
//$current_day = date('d', strtotime($date));

$year = [$current_year];
$month = [$current_month];
//$day = [$current_day];

$validYears = ['2018', '2019', '2020', '2021'];
$yearData = isset($_GET['year']) ? $_GET['year'] : false;
if ($yearData) {
	if (in_array($yearData, $validYears)) {
		$year = [$yearData];
	} else if ($yearData == 'all') {
		$year = $validYears;
	}
}

$validMonths = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
$monthData = isset($_GET['month']) ? $_GET['month'] : false;
if ($monthData) {
	if (in_array($monthData, $validMonths)) {
		$month = [$monthData];
	} else if ($monthData == 'all') {
		$month = $validMonths;
	}
}
/*
 * Run for all month for all dealer
 */
//$year = $validYears;
//$month = $validMonths;

$mail_report = [];

$need_skip_count = 0;
foreach ($dealerships as $dealer) {

	if ($need_skip_count >= $skip) {
		$dealer_mail_report = [];

		$dealerName = $dealer->dealerName;
		$domain = $dealer->domain;
		$cron_name = $dealer->cronName;
		$id = $dealer->id;
		$account = $dealer->account_id;
		$profile = $dealer->profile;
		$status = $dealer->status;


		$dealer_data_need_pull = true;

		if (!empty($dealer_cron_name)) {
			if ($cron_name !== $dealer_cron_name) {
				$dealer_data_need_pull = false;
			}
		}
		if(!$status){
			$dealer_data_need_pull = false;
		}


		if ($dealer_data_need_pull) {

			$mail_report[$cron_name] = "unsuccessful";

			$log_file_path = dirname(dirname(__DIR__)) . '/adwords3/caches/report-log/analytics' . $cron_name . '-analytics.txt';
			writeLog($log_file_path, "***** ***** ***** *****");
			writeLog($log_file_path, "Dealer name: $dealerName");
			writeLog($log_file_path, "ID: $id");
			writeLog($log_file_path, "Cron name: $cron_name");

			$vdp_regexes = load_vdp_configs(ADSYNCPATH . "data/vdp-config.json", $cron_name);


			$account_id = false;
			foreach ($account as $account_info) {
				if ($account_info->active && $account_info->dataPull) {
					$account_id = $account_info->idNo;
					$account_name = trim($account_info->account);
				}
			}

			$profile_id = false;
			foreach ($profile as $profile_info) {
				if ($profile_info->active && $profile_info->dataPull) {
					$profile_id = $profile_info->idNo;
					if (!$account_name) {
						$account_name = trim($profile_info->account);
					}
				}
			}


			echo "<br><br>==================================<br><br>";
			echo "Id: $id <br>";
			echo "Dealer name: $dealerName<br>";
			echo "Domain: $domain<br>";
			echo "Cron name: $cron_name<br>";
			echo "VDP URL Regex:: <br>";
			print_r($vdp_regexes);
			echo "<br>";

			/*
			 * Check Account id exist or not
			 */
			if (!$account_id) {

				writeLog($log_file_path, "No Analytics account id found in DB");
				echo "No Google account id found in DB";

			} else {

				writeLog($log_file_path, "Analytics account id : $account_id");
				echo "Analytics account id : $account_id<br>";

				/*
				 * Check Account name exist
				 */
				if (strlen($account_name)) {

					writeLog($log_file_path, "Analytics account Name : $account_name");
					echo "Analytics account Name : $account_name<br>";

					/*
					 * Set Analytics Object
					 */
					$analytics = new Analytics($account_name);

					if ($my_debug) {
						echo "<br>Analytics : <br>";
						print_r($analytics);
					}

					/*
					 * Check Profile Id exist or not in db
					 */
					$pro_id = false;
					if (!$profile_id) {
						writeLog($log_file_path, "No Profile id found in DB");
						echo "No Profile id found in DB<br>";

						$googleAccount = $analytics->GetAccountSummaries();

						if ($my_debug) {
							echo "<br>Profile Id Data : <br>";
							print_r($googleAccount);
						}

						if ($googleAccount) {

							writeLog($log_file_path, "Data found for Profile Id");
							echo "Data found for Profile Id <br>";

							foreach ($googleAccount->items as $account) {
								foreach ($account->webProperties as $webProperties) {
									if ($webProperties->id == $account_id) {
										writeLog($log_file_path, "Account Id Match");
										echo "Account Id Match<br>";

										if ($my_debug) {
											echo "<br>web Properties : <br>";
											print_r($webProperties);
										}

										foreach ($webProperties->profiles as $profiles) {
											if (count($webProperties->profiles) == 1) {
												$profile_id = $profiles->id;
												$pro_id = true;
												break 3;
											} else {
												$profileName = strtolower($profiles->name);
												if (strpos($profileName, 'smedia') !== false) {
													$profile_id = $profiles->id;
													$pro_id = true;
													break 3;
												} else if (strpos($profileName, 'All Web Site Data') !== false) {
													$profile_id = $profiles->id;
													$pro_id = true;
													break 3;
												}
											}
										}
									}
								}
							}

						} else {
							writeLog($log_file_path, "No data for found Profile Id");
							echo "<br>No data for found Profile Id <br>";
						}
					}

					/*
					 * Final check if profile id found or not
					 */
					if ($profile_id) {

						writeLog($log_file_path, "Profile Id: $profile_id");
						echo "Profile Id: $profile_id<br><br>";

						if ($pro_id) {
							$finalObject = array();
							$finalObject = array(
								"idNo" => $profile_id,
								"account" => $account_name ? $account_name : false
							);

							$post_data = json_encode($finalObject);
							$post_url_dealer = $post_url . "/dealer/$id/profileId";
							$res = HttpPost($post_url_dealer, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
						}


						foreach ($year as $y) {
							foreach ($month as $m) {
								$sdate = $y . '-' . $m . '-01';
								$date = new DateTime($sdate);
								$edate = $date->format('Y-m-t');
								$date_now = date("Y-m-d");

								$ym = $y . $m;


								if ($date_now > $sdate) {

									$dealer_mail_report[$ym] = "unsuccessful";

									echo "<br>Date : $sdate :: $edate <br>";
									writeLog($log_file_path, "Date - $sdate :: $edate");

									$report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration'), array('ga:sourceMedium', 'ga:campaign'));

									//	echo "<br>Report : <br>";
									//	print_r($report);

									$finalData = array();
									if (!$report->rows) {
										echo '<b>No Data Found </b><br>';
										writeLog($log_file_path, "No Data Found");
									} else {
										echo '<b>Data Found</b><br>';
										writeLog($log_file_path, "Data Found");
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

										$report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:sessions'), array('ga:sourceMedium', 'ga:campaign', 'ga:eventCategory'));

										//	echo "<br>Report of engaged Prospects  : <br>";
										//	print_r($report);

										if (!$report || !$report->rows) {
											echo 'No Row Found for engaged Prospects <br>';
											writeLog($log_file_path, "No Row Found for engaged Prospects");
										} else {
											echo 'Row Found for engaged Prospects <br>';
											writeLog($log_file_path, "Row Found for engaged Prospects");
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


										try {
											$time_on_page_report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:timeOnPage'), array('ga:sourceMedium', 'ga:campaign', 'ga:pagePath', 'ga:hostname'));
											if ($my_debug) {
												echo "<br>Time On Page Report<br>";
												print_r($time_on_page_report);
												echo "<br><br>";
											}

											if (!empty($time_on_page_report) && isset($time_on_page_report->rows) && is_array($time_on_page_report->rows)) {
												$time_on_vdp_report = filter_vdp_data($time_on_page_report->rows, $vdp_regexes);
												echo "TimeOnPage data found<br>";
												writeLog($log_file_path, "TimeOnPage data found");
											} else {
												echo "NO timeOnPage data found<br>";
												writeLog($log_file_path, "No timeOnPage data found");
											}
										} catch (Exception $e) {
											echo "<br>Time On VDP Catch Error<br>";
											print_r($e->getMessage());
											echo "<br><br>";
											writeLog($log_file_path, $e->getMessage());
										}

										unset($time_on_page_report);

										if (isset($time_on_vdp_report) && !empty($time_on_vdp_report) && is_array($time_on_vdp_report)) {
											$acc_report = [];
											foreach ($time_on_vdp_report as $row) {
												$key = "{$row[0]}||{$row[1]}";
												if (!isset($acc_report[$key])) {
													$acc_report[$key] = ["total_time" => 0, 'count' => 0];
												}
												$acc_report[$key]["total_time"] += floatval($row[4]);
												$acc_report[$key]["count"] += 1;
											}

											foreach ($finalData as $key => $item) {
												$acc_key = "{$item['sourceMedium']}||{$item['campaign']}";
												$avg = $acc_report[$acc_key]["count"] > 0 ? $acc_report[$acc_key]["total_time"] / $acc_report[$acc_key]["count"] : 0;
												$finalData[$key]['avgTimeOnVdp'] = gmdate("H:i:s", $avg);
											}
											unset($acc_report);
											unset($time_on_vdp_report);
										} else {
											echo "NO timeOnPage data found after filter_vdp_data<br>";
										}

										try {
											$event_report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:totalEvents'), array('ga:sourceMedium', 'ga:campaign', 'ga:pagePath', 'ga:hostname', 'ga:eventCategory'));

											if ($my_debug) {
												echo "<br>Picture view Report<br>";
												print_r($event_report);
												echo "<br><br>";
											}

											if (isset($event_report->rows) && is_array($event_report->rows)) {
												$picture_view_vdp_report = filter_picture_views($event_report->rows, $vdp_regexes);
												echo "Picture_view_vdp_report data found<br>";
												writeLog($log_file_path, "Picture_view_vdp_report data found");
											} else {
												echo "NO Picture_view_vdp_report data found<br>";
												writeLog($log_file_path, "No Picture_view_vdp_report data found");
											}
										} catch (Exception $e) {
											echo "<br>Picture view Catch Error<br>";
											print_r($e->getMessage());
											echo "<br><br>";
											writeLog($log_file_path, $e->getMessage());
										}

										unset($event_report);

										if (isset($picture_view_vdp_report) && !empty($picture_view_vdp_report) && is_array($picture_view_vdp_report)) {
											$acc_report = [];
											foreach ($picture_view_vdp_report as $row) {
												$key = "{$row[0]}||{$row[1]}";
												if (!isset($acc_report[$key])) {
													$acc_report[$key] = ["total_view" => 0, 'count' => 0];
												}
												$acc_report[$key]["total_view"] += floatval($row[5]);
												$acc_report[$key]["count"] += 1;
											}

											foreach ($finalData as $key => $item) {
												$acc_key = "{$item['sourceMedium']}||{$item['campaign']}";
												$finalData[$key]['avgPictureView'] = $acc_report[$acc_key]["count"] > 0 ? $acc_report[$acc_key]["total_view"] / $acc_report[$acc_key]["count"] : 0;
											}
											unset($acc_report);
											unset($picture_view_vdp_report);
										} else {
											echo "NO Picture_view_vdp_report data found after filter_picture_views<br>";
										}

										$myObj = array();
										$myObj['dealerId'] = $id;
										$myObj['key'] = "analytics";
										$myObj['data']['date'] = $ym;
										$myObj['data']['data'] = $finalData;
										$post_data = json_encode($myObj);

										$post_url_data_push = $post_url . "/dealer-data";
										$res = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

										$post_url_social_data_live = 'https://api.smedia.ca/v1/dealer-data';
										HttpPost($post_url_social_data_live, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

										echo "<br>Post Data : <br>";
										print_r($post_data);

										echo "<br>";
										print_r($res);
										writeLog($log_file_path, "Response ::  $res");
										$mail_report[$cron_name] = "successful";
										$dealer_mail_report[$ym] = "successful";
									}

									echo "<br><br>========================<br>";
								}
							}
						}


						if ($monthData == 'all') {
							print_r($dealer_mail_report);
							report_mail("Analytics For Cron:: $cron_name", $dealer_mail_report);
						}

					} else {
						writeLog($log_file_path, "No Profile Id");
						echo "No Profile Id";
					}

				} else {
					writeLog($log_file_path, "Analytics account Name Not Exist in DB");
					echo "Analytics account Name Not Exist in DB<br>";
				}
			}


		}


	}
	$need_skip_count++;
}
if ($monthData != 'all') {
	report_mail("Analytics", $mail_report);
}

function load_vdp_configs($file_path, $dealership)
{
	if (file_exists($file_path)) {
		try {
			$json_content = file_get_contents($file_path);
			if ($json_content) {
				$json = json_decode($json_content);
			}
			if (isset($json) && isset($json->configs)) {
				$configs = $json->configs;
				foreach ($configs as $c) {
					if (isset($c->domain_key) && $c->domain_key == $dealership) {
						return isset($c->vdp_url_regex) ? $c->vdp_url_regex : null;
					}
				}
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	return null;
}

function filter_picture_views($data, $vdp_patterns)
{
	return array_filter($data, function ($v) use ($vdp_patterns) {
		return $v[4] == "Picture Viewed" && is_vdp($v[2], $vdp_patterns);
	});
}

function is_vdp($url, $vdp_patterns)
{
	foreach ($vdp_patterns as $r) {
		preg_match($r, $url, $match);
		if (count($match) > 0) {
			return true;
		}
	}

	return false;
}

function filter_vdp_data($data, $vdp_patterns)
{
	return array_filter($data, function ($v) use ($vdp_patterns) {
		return is_vdp($v[2], $vdp_patterns);
	});
}
