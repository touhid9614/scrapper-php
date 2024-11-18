<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

if (!isset($argv[1])) {
    die('please specify one argument, the customer. example: php ng_costmonitor_launcher.php murry');
}

$_GET['customer'] = $argv[1];
session_start();

require_once('config.php');
require_once('Google/TokenHelper.php');
require_once('Google/Types.php');
require_once('Google/Util.php');
require_once('Google/Adwords.php');
require_once('Google/Consts.php');
require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('utils.php');
require_once('AdSyncer.php');
require_once('scrapper.php');
require_once('carlist-loader.php');

global $CronConfigs, $scrapper_configs, $number_of_retries, $custom_dealerships;

//set it to run for no timeout
secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

foreach ($scrapper_configs as $cron_name => $project_config)
{
    if (!isset($CronConfigs[$cron_name])) {
        slecho("ERROR: Scrapper cron does not have a sync configuration. Skipping project '" . $cron_name . "'");
        continue;
    }

    //adding number_of_retries to the config for scrapper
    $project_config['number_of_retries'] = $number_of_retries;

    slecho($cron_name);
    exec(
        'php '
        . escapeshellarg(__DIR__ . '/ng_costmonitor_worker.php') . ' '
        . escapeshellarg($cron_name) . ' '
        . escapeshellarg($argv[1])
        . ' > /dev/null &'
    );
}

foreach ($custom_dealerships as $cron_name => $cron_config)
{
    $cron_config['number_of_retries'] = $number_of_retries;
    
    slecho($cron_name);
    exec(
        'php '
        . escapeshellarg(__DIR__ . '/ng_costmonitor_worker.php') . ' '
        . escapeshellarg($cron_name) . ' '
        . escapeshellarg($argv[1])
        . ' > /dev/null &'
    );
}