<?php

# Turn off monthly report
exit;

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

if (!isset($_GET['customer'])) {
    if (!isset($argv[1])) {
        die('Nothing to do, need arguments.');
    }

    //emulate web variables for command line usage
    //at the moment needed in an image generation function
    $_SERVER['HTTPS']       = 'off';
    $_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
    $_SERVER['SERVER_PORT'] = '80';
    $_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

    $_GET['customer'] = $argv[1];
}

session_start();

require_once 'config.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Adwords.php';
require_once 'Google/Consts.php';
require_once 'Google/SessionManager.php';
require_once 'cron_misc.php';
require_once 'utils.php';
require_once 'AdSyncer.php';
require_once 'scrapper.php';
require_once 'PerformanceAdGroup.php';
require_once 'tag_db_connect.php';

global $CronConfigs, $custom_dealerships, $scrapper_configs;

secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

$start_time = time();

$check       = [];
$set15       = isset($_GET['on15']) ? $_GET['on15'] : false;
$report_sent = 0;

foreach ($CronConfigs as $cron_name => $cron_config) {
    if (!isset($scrapper_configs[$cron_name])) {
        continue;
    }
    do_report($cron_name, $cron_config, $set15, $check);
}

foreach ($custom_dealerships as $cron_name => $cron_config) {
    do_report($cron_name, $cron_config, $set15, $check, true);
}

$elapced = time() - $start_time;
slecho("Info: Total reports sent $report_sent");
slecho("Info: Total time taken $elapced seconds");

function do_report($cron_name, $cron_config, $set15, &$check, $custom = false)
{
    global $CurrentConfig, $developer_token, $report_sent;

    $on15  = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $range = isset($cron_config['range']) ? $cron_config['range'] : false;

    if ($range) {
        slecho('Skiping ranged report');
        return;
    }

    if ($on15 != $set15) {
        slecho('Skipping dealership ' . $cron_name);
        return;
    }

    slecho("Info: Checking cron '" . $cron_name . "'");
    if (!isset($cron_config['customer_id']) || !$cron_config['customer_id']) {return;}
    if (isset($check[$cron_config['customer_id']])) {return;}
    slecho("Info: Generating report for customer '" . $cron_config['customer_id'] . "'");
    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);

    $report = $service->GetReport($on15);

    $car_performance = $service->GetCarPerformance($on15);

    $top_cars = calculateTopCar($cron_name, $car_performance);

    if ($report && count($report) > 1) {
        $data     = base64_encode(serialize($report));
        $top_cars = base64_encode(serialize($top_cars));

        $report_url = GetBaseURL() . 'campaign-report.php?cron_name=' . $cron_name . '&data=' . $data . '&on15=' . $on15 . '&top_cars=' . $top_cars;
        if ($custom) {
            $report_url .= '&custom=true';
        }

        $message = HttpGet($report_url);

        if ($message) {
            $currentMonth = date('F');
            $lastMonth    = Date('F, Y', strtotime($currentMonth . " last month"));
            if (isset($cron_config['email'])) {
                $stat = SendEmail($cron_config['email'], 'offers@smedia.ca', 'Your monthly Adwords report for ' . $lastMonth, $message);
                slecho("Email sent status '$stat'");
                slecho("Info: Report is emailed to '" . $cron_config['email'] . "'");
                $check[$cron_config['customer_id']] = true;
                $report_sent++;
            } else {
                slecho("Warning: Email address is not defined");
            }
        } else {
            slecho("Error: Unable to generate email message");
        }
    } else {
        slecho("Warning: No campaign present");
    }
}
