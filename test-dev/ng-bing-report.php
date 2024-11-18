<?php

ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
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

/*
 * For bing ads included these file
 */
require_once '../adwords3/bing/adSyncer.php';
require_once '../adwords3/bing/myBingAds.php';
require_once '../adwords3/carlist-loader.php';

global $CronConfigs, $CurrentConfig, $developer_token;

//$timePeriod = isset($_GET['time']) ? $_GET['time'] : 'LastMonth' ;

echo '<pre>';
/*
 * Get all campaign with account id
 */

//$allCampaign = getAllCampaign($account_id);

//print_r($allCampaign);

/*
 * GetAudiencePerformanceReportRequest
 */

/*

$performanceReport = GetAudiencePerformanceReportRequest($account_id,$timePeriod);
echo '++++++++++++++++++<br>';
print_r($performanceReport);

print("<br>-----SubmitGenerateReport------");
$reportRequestId = getRequestReportID($performanceReport) ;

print("<br>Report Request ID: $reportRequestId");

if($reportRequestId){
print_report($reportRequestId,$DownloadPath.'.zip');
}
$reportRequestId = '1237590663085';
print_report($reportRequestId,$DownloadPath.'x.zip');
 */

/*
 * GetAccountPerformanceReportRequest
 */

/*
$performanceReport = GetAccountPerformanceReportRequest($account_id,$timePeriod);
echo '<br><br>=====================++++++++++++++++++===============<br>';
print_r($performanceReport);

print("<br>-----SubmitGenerateReport------");
$reportRequestId = getRequestReportID($performanceReport) ;

print("<br>Report Request ID: $reportRequestId");

if($reportRequestId){
print_report($reportRequestId,$DownloadPath.'1.zip');
}

 */

/*
writeLog($log_file_path, "Bing Account Id $account_id");
writeLog($log_file_path, "Time $timePeriod");
$performanceReport = GetAdPerformanceReportRequest($account_id,$timePeriod);
//echo '<br><br>=====================++++++++++++++++++===============<br>';
//print_r($performanceReport);

//print("<br>-----SubmitGenerateReport------");
$reportRequestId = getRequestReportID($performanceReport) ;

writeLog($log_file_path, "Report Request ID: $reportRequestId");
//print("<br>Report Request ID: $reportRequestId");

if($reportRequestId){
$downloadURL = print_report($reportRequestId);
writeLog($log_file_path, "Download Link: $downloadURL");
$dataArray = bingFileRead($downloadURL);
if(!$dataArray){
writeLog($log_file_path, "###ERROR: Error in read zip file");
} else {
writeLog($log_file_path, "Data read successfully");
print_r($dataArray);
}

}
 */

$allMonth = isset($_GET['month']) ? (($_GET['month'] == "all") ? true : false) : false;
if ($allMonth) {
    $year  = ['2017', '2018', '2019', '2020'];
    $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
} else {
    $year  = ['2020'];
    $month = ['10', '11', '12'];
}

foreach ($dealerships as $cron_name => $id) {

    $log_file_path = dirname(__DIR__) . '/adwords3/caches/report-log/' . $cron_name . '-bing.txt';
    writeLog($log_file_path, "***** ***** ***** *****");
    writeLog($log_file_path, "Cron_name: $cron_name");
    writeLog($log_file_path, "Id: $id");

    if (array_key_exists($cron_name, $CronConfigs)) {
        $cron_config = $CronConfigs[$cron_name];
        $account_id  = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';

        if (!$account_id) {
            writeLog($log_file_path, "no bing account id found for $cron_name");
        } else {
            writeLog($log_file_path, "Bing account id : $account_id");
            /*
             * Bing ads authentication function
             */

            writeLog($log_file_path, "***** Try Bing Authentication");
            getAuthentication($account_id, $log_file_path);
            writeLog($log_file_path, "Bing Authentication");

            writeLog($log_file_path, "Bing Account Id $account_id");
            //writeLog($log_file_path, "Time $timePeriod");
            $post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1/social-data' : 'https://api-qa.smedia.ca/v1/social-data';

            foreach ($year as $y) {
                foreach ($month as $m) {
                    $start_day   = 01;
                    $start_month = $m;
                    $start_year  = $y;

                    $sdate     = $y . '-' . $m . '-01';
                    $end_day   = date('t', strtotime($sdate));
                    $end_month = $m;
                    $end_year  = $y;

                    $date  = new DateTime($sdate);
                    $edate = $date->format('Y-m-t');

                    $date_now   = date("Y-m-d");
                    $check_date = "2017-09-01";
                    if ($date_now > $sdate && $sdate > $check_date) {

                        writeLog($log_file_path, "Time $sdate :: $edate");
                        $performanceReport = GetCampaignerformanceReportRequest($account_id, $start_day, $start_month, $start_year, $end_day, $end_month, $end_year);
                        //echo '<br><br>=====================++++++++++++++++++===============<br>';
                        //print_r($performanceReport);

                        //print("<br>-----SubmitGenerateReport------");
                        $reportRequestId = getRequestReportID($performanceReport);

                        writeLog($log_file_path, "Report Request ID: $reportRequestId");
                        //print("<br>Report Request ID: $reportRequestId");

                        if ($reportRequestId) {
                            $downloadURL = print_report($reportRequestId);
                            writeLog($log_file_path, "Download Link: $downloadURL");
                            $dataArray = bingFileRead($downloadURL);
                            if (!$dataArray) {
                                writeLog($log_file_path, "###ERROR: Error in read zip file");
                            } else {
                                writeLog($log_file_path, "Data read successfully");
								// print_r($dataArray);
                                $finalObject = array();
                                $finalData   = array();
                                foreach ($dataArray as $item) {
                                    $myObj                                     = array();
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

                                    $finalData[] = $myObj;

                                }

                                $finalObject['dealerId']     = $id;
                                $finalObject['key']          = "bing";
                                $finalObject['data']['date'] = $sdate;
                                $finalObject['data']['data'] = $finalData;
                                $post_data                   = json_encode($finalObject);

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

                }
            }
        }
    } else {
        writeLog("This dealership is either invalid or inactive, Invalid dealer name. Give a valid dealer name!!!!!!!!!!!!!!!!");
    }
    echo "<br><br>*************************************** <br><br>";
}
