<?php

ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';

require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'Google/Types.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/SessionManager.php';

require_once 'email.php';

global $CronConfigs, $CurrentConfig, $developer_token;

$_GET['api']                       = 'api';
$post_url                          = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

echo '<pre>';

$pull_static = isset($_GET['one']) ? true : false;

if (!$pull_static) {
    $post_url_dealer_id_pull = $post_url . "/dealer-account-id/google";
    $res                     = HttpGet($post_url_dealer_id_pull, false, false, '', $nothing, 'application/json', $additional_headers);
    $dealerships             = json_decode($res);
} else {
    $dealerships["winnipegautogroup"] = (object) [
        'dealerName' => 'winnipegautogroup',
        'cronName'   => 'winnipegautogroup',
        'id'         => '5fb6b6234f5467001db9659e',
        'account_id' => '111-894-6846',
    ];

    $dealer_data_need_pull = true;
}

$dealer_cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : '';
$date             = date('Y-m-d', strtotime("-1 day"));
$current_year     = date('Y', strtotime($date));
$current_month    = date('m', strtotime($date));
$current_day      = date('d', strtotime($date));

$year  = [$current_year];
$month = [$current_month];
$day   = [$current_day];

$validYears = ['2018', '2019', '2020', '2021'];
$yearData   = isset($_GET['year']) ? $_GET['year'] : false;

if ($yearData) {
    if (in_array($yearData, $validYears)) {
        $year = [$yearData];
    } else if ($yearData == 'all') {
        $year = $validYears;
    }
}

$validMonths = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
$monthData   = isset($_GET['month']) ? $_GET['month'] : false;

if ($monthData) {
    if (in_array($monthData, $validMonths)) {
        $month = [$monthData];
    } else if ($monthData == 'all') {
        $month = $validMonths;
    }
}

$mail_report = [];

foreach ($dealerships as $dealer) {
    $dealerName = $dealer->dealerName;
    $cron_name  = $dealer->cronName;
    $id         = $dealer->id;
    $account    = $dealer->account_id;

    $dealer_data_need_pull = true;

    if (!empty($dealer_cron_name)) {
        if ($cron_name !== $dealer_cron_name) {
            $dealer_data_need_pull = false;
        }
    }

    if ($dealer_data_need_pull) {
        $mail_report[$cron_name] = "unsuccessful";

        $log_file_path = dirname(dirname(__DIR__)) . '/adwords3/caches/report-log/' . $cron_name . '-google.txt';
        writeLog($log_file_path, "***** ***** ***** *****");
        writeLog($log_file_path, "Dealer name: $dealerName");
        writeLog($log_file_path, "ID: $id");
        writeLog($log_file_path, "Cron name: $cron_name");

        if (!$pull_static) {
            $account_id = false;
            foreach ($account as $account_info) {
                if ($account_info->active && $account_info->dataPull) {
                    $account_id = $account_info->idNo;
                }
            }
        } else {
            $account_id = $dealer->account_id;
        }

        echo "Dealer name: $dealerName<br>";
        echo "Id: $id <br>";
        echo "Cron name: $cron_name<br>";

        if (!$account_id) {
            writeLog($log_file_path, "No google account id found in DB");
            echo "No Google account id found in DB";
        } else {
            writeLog($log_file_path, "Google account id : $account_id");
            echo "Google account id : $account_id<br><br>";

            $service = new AdwordsService(
                Consts::ServiceNamespace,
                $CurrentConfig,
                $developer_token,
                $account_id
            );

            foreach ($year as $y) {
                foreach ($month as $m) {
                    $sdate    = $y . '-' . $m . '-01';
                    $end_day  = date('t', strtotime($sdate));
                    $date     = new DateTime($sdate);
                    $edate    = $date->format('Y-m-t');
                    $date_now = date("Y-m-d");
                    $ym       = $y . $m;

                    if ($date_now > $sdate) {

                        $during = $y . $m . '01,' . $y . $m . $end_day;
                        writeLog($log_file_path, "Time- $sdate :: $edate");
                        echo "Time- $sdate :: $edate<br>";

                        $report      = $service->GetROIReport($during);
                        $finalObject = [];
                        $finalData   = [];

                        foreach ($report as $item) {

                            if ($item['Campaign ID'] != 'Total') {
                                $myObj                                     = [];
                                $myObj['campaignName']                     = trim(str_replace('-', '', $item['Campaign']));
                                $myObj['campaignID']                       = trim(str_replace('-', '', $item['Campaign ID']));
                                $myObj['clicks']                           = trim(str_replace('-', '', $item['Clicks']));
                                $myObj['impressions']                      = trim(str_replace('-', '', $item['Impressions']));
                                $myObj['ctr']                              = trim(str_replace('-', '', $item['CTR']));
                                $myObj['averageCpc']                       = trim(str_replace('-', '', $item['Avg. CPC']));
                                $myObj['cost']                             = trim(str_replace('-', '', $item['Cost'])) / 1000000;
                                $myObj['searchExactmatchIS']               = trim(str_replace('-', '', $item['Search Exact match IS']));
                                $myObj['SearchImprShare']                  = trim(str_replace('-', '', $item['Search Impr. share']));
                                $myObj['SearchBudgetLostImpressionShare']  = trim(str_replace('-', '', $item['Search Lost IS (budget)']));
                                $myObj['SearchRankLostImpressionShare']    = trim(str_replace('-', '', $item['Search Lost IS (rank)']));
                                $myObj['ContentImpressionShare']           = trim(str_replace('-', '', $item['Content Impr. share']));
                                $myObj['ContentBudgetLostImpressionShare'] = trim(str_replace('-', '', $item['Content Lost IS (budget)']));
                                $myObj['ContentRankLostImpressionShare']   = trim(str_replace('-', '', $item['Content Lost IS (rank)']));

                                $finalData[] = $myObj;
                            } else {
                                $sum                                     = [];
                                $sum['campaignName']                     = trim(str_replace('-', '', $item['Campaign']));
                                $sum['campaignID']                       = trim(str_replace('-', '', $item['Campaign ID']));
                                $sum['clicks']                           = trim(str_replace('-', '', $item['Clicks']));
                                $sum['impressions']                      = trim(str_replace('-', '', $item['Impressions']));
                                $sum['ctr']                              = trim(str_replace('-', '', $item['CTR']));
                                $sum['averageCpc']                       = trim(str_replace('-', '', $item['Avg. CPC']));
                                $sum['cost']                             = trim(str_replace('-', '', $item['Cost'])) / 1000000;
                                $sum['searchExactmatchIS']               = trim(str_replace('-', '', $item['Search Exact match IS']));
                                $sum['SearchImprShare']                  = trim(str_replace('-', '', $item['Search Impr. share']));
                                $sum['SearchBudgetLostImpressionShare']  = trim(str_replace('-', '', $item['Search Lost IS (budget)']));
                                $sum['SearchRankLostImpressionShare']    = trim(str_replace('-', '', $item['Search Lost IS (rank)']));
                                $sum['ContentImpressionShare']           = trim(str_replace('-', '', $item['Content Impr. share']));
                                $sum['ContentBudgetLostImpressionShare'] = trim(str_replace('-', '', $item['Content Lost IS (budget)']));
                                $sum['ContentRankLostImpressionShare']   = trim(str_replace('-', '', $item['Content Lost IS (rank)']));

                            }
                        }

                        if (count($finalData)) {
                            $finalObject['dealerId']     = $id;
                            $finalObject['key']          = "google";
                            $finalObject['data']['date'] = $ym;
                            $finalObject['data']['data'] = $finalData;
                            $finalObject['data']['sum']  = $sum;
                            $post_data                   = json_encode($finalObject);

                            $post_url_social_data = $post_url . '/dealer-data';
                            $res                  = HttpPost($post_url_social_data, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

                            echo "<br>";
                            print_r($res);
                            echo "<br>===================<br>";
                            writeLog($log_file_path, "Response ::  $res");
                            $mail_report[$cron_name] = "successful";
                        } else {
                            echo "No Data found<br>";
                            echo "<br>===================<br>";
                            writeLog($log_file_path, "No Data found");
                        }

                    }
                }
            }
        }
        echo "<br><br>*************************************** <br><br>";
    }
}

report_mail("Google Adwords", $mail_report);
