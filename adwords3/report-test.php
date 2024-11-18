<?php session_start();

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

global $CronConfigs, $custom_dealerships;

secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

$start_time = time();

$check = [];
$set15 = isset($_GET['on15']) ? $_GET['on15'] : false;

$cron_name   = isset($_GET['cron_name']) ? $_GET['cron_name'] : 'barbermotors';
$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

do_report($cron_name, $cron_config, $set15, $check);

$elapced = time() - $start_time;
slecho("Info: Total time taken " . $elapced . "seconds");

function do_report($cron_name, $cron_config, $set15, &$check, $custom = false)
{
    global $CurrentConfig, $developer_token;

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
        if ($custom) {$report_url .= '&custom=true';}

        slecho($report_url);

        $message = HttpGet($report_url);

        if ($message) {
            $currentMonth = date('F');
            $lastMonth    = Date('F, Y', strtotime($currentMonth . " last month"));
            if (isset($cron_config['email'])) {
                $stat = SendEmail('offers@smedia.ca', 'Your monthly Adwords report for ' . $lastMonth, $message,
                    array(
                        'host'         => 'smtp.gmail.com',
                        'port'         => 587,
                        'auth_enabled' => true,
                        'auth_user'    => 'offers@smedia.ca',
                        'auth_pass'    => '=6JRm4Vd^t',
                        'smtp_secure'  => 'tls',
                    ));
                slecho("Email sent status '$stat'");
                slecho("Info: Report is emailed to '" . $cron_config['email'] . "'");
                $check[$cron_config['customer_id']] = true;
            } else {
                slecho("Warning: Email address is not defined");
            }
        } else {
            slecho("Error: Unable to generate email message");
        }
    }
}
