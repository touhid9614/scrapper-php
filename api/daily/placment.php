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

require_once $base_path . '/api/dealer-transfer/email.php';

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

$dealer_cron_name = isset($_GET['dealer']) ? $_GET['dealer']: '';
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

$dayData = isset($_GET['day']) ? $_GET['day'] : false;
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

        $log_file_path = dirname(dirname(__DIR__)) . '/adwords3/caches/report-log/' . $cron_name . '-daily-placement.txt';
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

        echo "Dealer name: {$dealerName}<br>";
        echo "Id: {$id} <br>";
        echo "Cron name: {$cron_name}<br>";

        if (!$account_id) {
            writeLog($log_file_path, "No Google account id found in DB.");
            echo "No Google account id found in DB.";
        } else {
            writeLog($log_file_path, "Google account id : {$account_id}.");
            echo "Google account id : {$account_id}.<br><br>";

            $service = new AdwordsService(
                Consts::ServiceNamespace,
                $CurrentConfig,
                $developer_token,
                $account_id
            );

            foreach ($year as $y) {
                foreach ($month as $m) {
                    if ($dayData) {
                        if ($dayData == 'all') {
                            $day     = [];
                            $sdate   = $y . '-' . $m . '-01';
                            $end_day = date('t', strtotime($sdate));

                            for ($dayValue = 1; $dayValue <= $end_day; $dayValue++) {
                                $num_padded = sprintf("%02d", $dayValue);
                                array_push($day, $num_padded);
                            }
                        } else {
                            if (checkdate($m, $dayData, $y)) {
                                $day = [];
                                $day = [$dayData];
                            }
                        }
                    }

                    echo "<br>=========<br>";

                    foreach ($day as $d) {
                        $check_date = $y . '-' . $m . '-' . $d;
                        $date_now   = date("Y-m-d");

                        if ($date_now > $check_date) {
                            $ymd    = $y . $m . $d;
                            $during = $y . $m . $d . ',' . $y . $m . $d;
                            writeLog($log_file_path, "Time- {$check_date}");
                            echo "Date:: {$check_date} <br>";

                            $report      = $service->GetKeywordPerformanceByNewwork($during);
                            $finalObject = [];
                            $finalData   = [];
                            $finalD      = [];

                            foreach ($report as $item) {
                                $key         = $item['Network (with search partners)'];
                                $impressions = $item['Impressions'];
                                if (array_key_exists($key, $finalD)) {
                                    $finalD[$key] += $impressions;
                                } else {
                                    $finalD[$key] = $impressions;
                                }
                            }

                            foreach ($finalD as $fd => $value) {
                                if ($fd == 'Total') {
                                    $sum                = [];
                                    $sum['placement']   = 'Total';
                                    $sum['impressions'] = $value;
                                } else {
                                    $myObj                = [];
                                    $myObj['placement']   = $fd;
                                    $myObj['impressions'] = $value;
                                    $finalData[]          = $myObj;
                                }
                            }

                            if (count($finalData)) {
                                $finalObject['dealerId']     = $id;
                                $finalObject['key']          = "google_placement";
                                $finalObject['data']['date'] = $ymd;
                                $finalObject['data']['data'] = $finalData;
                                $finalObject['data']['sum']  = $sum;
                                $post_data                   = json_encode($finalObject);

                                $post_url_social_data = $post_url . '/dealer-daily-data';
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
        }
        echo "<br><br>*************************************** <br><br>";
    }
}

report_mail("Google Placement", $mail_report);
