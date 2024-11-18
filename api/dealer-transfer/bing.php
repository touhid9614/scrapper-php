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
require_once ADSYNCPATH . 'bing/adSyncer.php';
require_once ADSYNCPATH . 'bing/myBingAds.php';

require_once 'email.php';

global $CronConfigs, $CurrentConfig, $developer_token;

$_GET['api']                       = 'api';
$post_url                          = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

echo '<pre>';
$post_url_dealer_id_pull = $post_url . "/dealer-account-id/bing";

$res              = HttpGet($post_url_dealer_id_pull, false, false, '', $nothing, 'application/json', $additional_headers);
$dealerships      = json_decode($res);
$dealer_cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : '';
$allMonth         = isset($_GET['month']) ? true : false;

if ($allMonth) {
    if ($_GET['month'] == 2018) {
        $year  = ['2018'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2019) {
        $year  = ['2019'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2020) {
        $year  = ['2020'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2021) {
        $year  = ['2021'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else {
        $year  = ['2018', '2019', '2020', '2021'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    }
} else {
    $current_year  = date('Y');
    $current_month = date('m');
    $year          = [$current_year];
    $month         = [$current_month];
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

        $log_file_path = dirname(dirname(__DIR__)) . '/adwords3/caches/report-log/' . $cron_name . '-bing.txt';
        writeLog($log_file_path, "***** ***** ***** *****");
        writeLog($log_file_path, "Dealer name: $dealerName");
        writeLog($log_file_path, "ID: $id");
        writeLog($log_file_path, "Cron name: $cron_name");

        $account_id = false;
        foreach ($account as $account_info) {
            if ($account_info->active && $account_info->dataPull) {
                $account_id = $account_info->idNo;
            }
        }

        echo "Dealer name: $dealerName<br>";
        echo "Id: $id <br>";
        echo "Cron name: $cron_name<br>";

        if (!$account_id) {
            writeLog($log_file_path, "No Bing account id found in DB");
            echo "No Bing account id found in DB";
        } else {
            writeLog($log_file_path, "Bing account id : $account_id");
            echo "Bing account id : $account_id<br><br>";

            writeLog($log_file_path, "Try Bing Authentication");
            getAuthentication($account_id, $log_file_path);
            writeLog($log_file_path, "Bing Authentication");

            foreach ($year as $y) {
                foreach ($month as $m) {
                    $start_day   = 01;
                    $start_month = $m;
                    $start_year  = $y;
                    $end_month   = $m;
                    $end_year    = $y;

                    $sdate = $y . '-' . $m . '-01';
                    if ($y == date('Y') && $m == date('m')) {
                        $end_day = date('d');
                    } else {
                        $end_day = date('t', strtotime($sdate));
                    }

                    $edate    = $y . '-' . $m . '-' . $end_day;
                    $date_now = date("Y-m-d");

                    $ym = $y . $m;

                    if ($date_now >= $edate) {

                        writeLog($log_file_path, "Time $sdate :: $edate");
                        echo "Time- $sdate :: $edate<br>";
                        $performanceReport = GetCampaignerformanceReportRequest($account_id, $start_day, $start_month, $start_year, $end_day, $end_month, $end_year);

                        $reportRequestId = getRequestReportID($performanceReport);

                        writeLog($log_file_path, "Report Request ID: $reportRequestId");

                        if ($reportRequestId) {
                            $downloadURL = print_report($reportRequestId);
                            writeLog($log_file_path, "Download Link: $downloadURL");
                            $dataArray = bingFileRead($downloadURL);

                            if (!$dataArray) {
                                writeLog($log_file_path, "###ERROR: Error in read zip file");
                            } else {
                                writeLog($log_file_path, "Data read successfully");

                                $finalObject = [];
                                $finalData   = [];
                                foreach ($dataArray as $item) {
                                    $myObj                                     = [];
                                    $myObj['accountId']                        = trim(str_replace('"', '', $item['AccountId']));
                                    $myObj['accountName']                      = trim(str_replace('"', '', $item['AccountName']));
                                    $myObj['campaignName']                     = trim(str_replace('"', '', $item['CampaignName']));
                                    $myObj['campaignId']                       = trim(str_replace('"', '', $item['CampaignId']));
                                    $myObj['campaignStatus']                   = trim(str_replace('"', '', $item['CampaignStatus']));
                                    $myObj['campaignType']                     = trim(str_replace('"', '', $item['CampaignType']));
                                    $myObj['clicks']                           = trim(str_replace('"', '', $item['Clicks']));
                                    $myObj['impressions']                      = trim(str_replace('"', '', $item['Impressions']));
                                    $myObj['impressionSharePercent']           = trim(str_replace('"', '', $item['ImpressionSharePercent']));
                                    $myObj['exactMatchImpressionSharePercent'] = trim(str_replace('"', '', $item['ExactMatchImpressionSharePercent']));
                                    $myObj['ctr']                              = trim(str_replace('"', '', $item['Ctr']));
                                    $myObj['averageCpc']                       = trim(str_replace('"', '', $item['AverageCpc']));
                                    $myObj['spend']                            = trim(str_replace('"', '', $item['Spend']));
                                    $myObj['ImpressionLostToBudgetPercent']    = trim(str_replace('"', '', $item['ImpressionLostToBudgetPercent']));
                                    $myObj['ImpressionLostToRankAggPercent']   = trim(str_replace('"', '', $item['ImpressionLostToRankAggPercent']));

                                    $finalData[] = $myObj;
                                }

                                $finalObject['dealerId']     = $id;
                                $finalObject['key']          = "bing";
                                $finalObject['data']['date'] = $ym;
                                $finalObject['data']['data'] = $finalData;
                                $post_data                   = json_encode($finalObject);

                                $post_url_social_data = $post_url . '/dealer-data';
                                $res                  = HttpPost($post_url_social_data, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

                                $post_url_social_data_qa = 'https://api-qa.smedia.ca/v1/dealer-data';
                                HttpPost($post_url_social_data_qa, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

                                print_r($post_data);
                                echo "<br>";
                                print_r($res);
                                writeLog($log_file_path, "Response ::  $res");
                                echo "<br>===================<br>";
                                $mail_report[$cron_name] = "successful";
                            }
                        }
                    }
                }
            }
        }
        echo "<br><br>*************************************** <br><br>";
    }

}

report_mail("Bing", $mail_report);