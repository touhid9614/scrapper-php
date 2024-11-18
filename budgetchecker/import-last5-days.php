<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ABSPATH . 'includes/ajax_inc.php';

/**
 * { function_description }
 *
 * @param      string  $data   The data
 */
function slecho($data)
{
    echo $data . '<br/>';
}

set_time_limit(0);

global $CronConfigs, $custom_dealerships, $set_path, $connection;

$start_time    = 1420092000;
$end_time      = time();
$db_connect    = new DbConnect('murraywin');
$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];

foreach ($CronConfigs as $cron_name => $cron_config) {
    $customer_id = $cron_config['customer_id'];
    $local_time  = $start_time;

    while ($local_time < $end_time) {
        $during = daily_during($local_time);
        $report = get_ranged_report($CurrentConfig, $customer_id, $during);
        $calc   = report2cic($cron_name, $report);
        $db_connect->store_account_state($customer_id, $local_time, $calc['cost'], $calc['clicks'], $calc['impressions']);
        $local_time -= 86400;
    }
}

foreach ($custom_dealerships as $cron_name => $cron_config) {
    $customer_id = $cron_config['customer_id'];

    $local_time = $start_time;

    while ($local_time < $end_time) {
        $during = daily_during($local_time);
        $report = get_ranged_report($CurrentConfig, $customer_id, $during);
        $calc   = report2cic($cron_name, $report, true);
        $db_connect->store_account_state($customer_id, $local_time, $calc['cost'], $calc['clicks'], $calc['impressions']);
        $local_time -= 86400;
    }
}

$db_connect->close_connection();

/**
 * { function_description }
 *
 * @param      <type>  $time   The time
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function daily_during($time)
{
    return date('Ymd', $time) . ',' . date('Ymd', $time);
}