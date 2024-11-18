<?php

ini_set('display_errors', 1);
ini_set("log_errors", 1);
error_reporting(E_ALL);

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';

global $single_config;
$cron_name = $single_config = isset($_GET['dealer']) ? $_GET['dealer'] : '';
$id        = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($cron_name) && !empty($id)) {
    $dealerships[$cron_name] = $id;
} else {
    $dealerships['crestviewchrysler']    = '5df1e2e77c0f1f7df41c31e2';
    $dealerships['knightnissan']         = '5df1e2e77c0f1f7df41c31e3';
    $dealerships['knightfordlincoln']    = '5df1e2e77c0f1f7df41c31e4';
    $dealerships['knightdodgeofweyburn'] = '5df1e2e77c0f1f7df41c31e5';
    $dealerships['knightdodge']          = '5df1e2e77c0f1f7df41c31e6';
}

require_once '../adwords3/config.php';
require_once '../adwords3/utils.php';
require_once '../adwords3/Google/TokenHelper.php';
require_once '../adwords3/Google/Types.php';
require_once '../adwords3/Google/Util.php';
require_once '../adwords3/Google/Consts.php';
require_once '../adwords3/Google/Adwords.php';
require_once '../adwords3/Google/Analytics.php';
require_once '../adwords3/Google/SessionManager.php';
require_once '../adwords3/cron_misc.php';
require_once '../adwords3/db_connect.php';
require_once '../adwords3/AdSyncer.php';
require_once '../adwords3/scrapper.php';

global $CronConfigs, $CurrentConfig, $developer_token, $custom_dealerships;

$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1/social-data' : 'https://api-qa.smedia.ca/v1/social-data';

echo '<pre>';
$allMonth = isset($_GET['month']) ? (($_GET['month'] == "all") ? true : false) : false;
if ($allMonth) {
    $year  = ['2017', '2018', '2019', '2020'];
    $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
} else {
    $year  = ['2020'];
    $month = ['10', '11', '12'];
}
foreach ($dealerships as $cron_name => $id) {
    $log_file_path = dirname(__DIR__) . '/adwords3/caches/report-log/' . $cron_name . '-google.txt';
    writeLog($log_file_path, "***** ***** ***** *****");
    writeLog($log_file_path, "Cron_name: $cron_name");
    writeLog($log_file_path, "Id: $id");

    echo "Cron_name: $cron_name<br>";
    echo "Id: $id <br>";

    if (array_key_exists($cron_name, $CronConfigs)) {
        $cron_config = $CronConfigs[$cron_name];
        $account_id  = isset($cron_config['customer_id']) ? $cron_config['customer_id'] : '';

        if (!$account_id) {
            writeLog($log_file_path, "no google account id found for $cron_name");
        } else {
            writeLog($log_file_path, "Google account id : $account_id");
            foreach ($year as $y) {
                foreach ($month as $m) {
                    $sdate   = $y . '-' . $m . '-01';
                    $end_day = date('t', strtotime($sdate));

                    $date  = new DateTime($sdate);
                    $edate = $date->format('Y-m-t');

                    $date_now = date("Y-m-d");
                    if ($date_now > $sdate) {

                        $during = $y . $m . '01,' . $y . $m . $end_day;
                        writeLog($log_file_path, "Time- $sdate :: $edate");

                        $service = new AdwordsService(
                            Consts::ServiceNamespace,
                            $CurrentConfig,
                            $developer_token,
                            $cron_config['customer_id']
                        );

                        $report = $service->GetROIReport($during);
//                        print_r($report);

                        $finalObject = array();
                        $finalData   = array();
                        foreach ($report as $item) {

                            if ($item['Campaign ID'] != 'Total') {
                                $myObj                       = array();
                                $myObj['campaignName']       = trim(str_replace('-', '', $item['Campaign']));
                                $myObj['campaignID']         = trim(str_replace('-', '', $item['Campaign ID']));
                                $myObj['clicks']             = trim(str_replace('-', '', $item['Clicks']));
                                $myObj['impressions']        = trim(str_replace('-', '', $item['Impressions']));
                                $myObj['ctr']                = trim(str_replace('-', '', $item['CTR']));
                                $myObj['averageCpc']         = trim(str_replace('-', '', $item['Avg. CPC']));
                                $myObj['cost']               = trim(str_replace('-', '', $item['Cost'])) / 1000000;
                                $myObj['searchExactmatchIS'] = trim(str_replace('-', '', $item['Search Exact match IS']));
                                $myObj['SearchImprShare']    = trim(str_replace('-', '', $item['Search Impr. share']));

                                $finalData[] = $myObj;
                            } else {
                                $sum                       = array();
                                $sum['campaignName']       = trim(str_replace('-', '', $item['Campaign']));
                                $sum['campaignID']         = trim(str_replace('-', '', $item['Campaign ID']));
                                $sum['clicks']             = trim(str_replace('-', '', $item['Clicks']));
                                $sum['impressions']        = trim(str_replace('-', '', $item['Impressions']));
                                $sum['ctr']                = trim(str_replace('-', '', $item['CTR']));
                                $sum['averageCpc']         = trim(str_replace('-', '', $item['Avg. CPC']));
                                $sum['cost']               = trim(str_replace('-', '', $item['Cost'])) / 1000000;
                                $sum['searchExactmatchIS'] = trim(str_replace('-', '', $item['Search Exact match IS']));
                                $sum['SearchImprShare']    = trim(str_replace('-', '', $item['Search Impr. share']));
                            }
                        }

                        $finalObject['dealerId']     = $id;
                        $finalObject['key']          = "google";
                        $finalObject['data']['date'] = $sdate;
                        $finalObject['data']['data'] = $finalData;
                        $finalObject['data']['sum']  = $sum;
                        $post_data                   = json_encode($finalObject);

                        $additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

                        $res = HttpPost($post_url, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
                        print_r($post_data);
                        echo "<br>";
                        print_r($res);
                        echo "<br>===================<br>";
                        writeLog($log_file_path, "Response ::  $res");

                    }
                }
            }
        }
    } else {
        writeLog("This dealership is either invalid or inactive, Invalid dealer name. Give a valid dealer name!!!!!!!!!!!!!!!!");
    }

    echo "<br><br>*************************************** <br><br>";
}
