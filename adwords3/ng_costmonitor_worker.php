<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

if (!isset($argv[2]))
{
    die('Nothing to do, need arguments.');
}


//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS'] = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes


$_GET['customer'] = $argv[2];
//$_GET['scrap'] = 'true';

//print_r($argv);
$cron_name = $argv[1];

$worker_log_dir = __DIR__ . '/ng_cost_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $cron_name);

if (!file_exists($worker_log_dir))
{
    if (!mkdir($worker_log_dir))
    {
        die('can not create logging directory');
    }
}


$worker_logfile = $worker_log_dir .'/'. date('Y-m-d_H:i:s_') .substr((string)microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

$cron_config = null;

function logme_nostrip($text)
{
    global $worker_logfile, $cron_config;

    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log']))
    {
        file_put_contents($worker_logfile, $text."\n", FILE_APPEND);
    }
}

function logme($text)
{
    global $worker_logfile, $cron_config;

    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log']))
    {
        file_put_contents($worker_logfile, strip_tags($text)."\n", FILE_APPEND);
    }
}

session_start();

logme(print_r($argv, true));
logme('Starting cost monitor worker');
$grepstring = 'ps aux  | grep -v grep | grep '
    . escapeshellarg('ng_costmonitor_worker.php '.$argv[1].' '.$argv[2])
    . ' | grep -v sudo';
logme($grepstring);
logme(`$grepstring`);

if (`$grepstring | wc -l` > 1)
{
    logme("already running, quitting");
    die();
}
else
{
    logme("Not already running");
}

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

global $CronConfigs, $CurrentConfig, $developer_token, $custom_dealerships;

//set it to run for no timeout
secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

slecho("Starting cost monitor cron for '" . $cron_name . "'");

$cron_config = isset($CronConfigs[$cron_name])? $CronConfigs[$cron_name] : false;

if ($cron_config)
{
    slecho("Cron type: Regular");

    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );

    if (isset($cron_config['no_adv']) && $cron_config['no_adv'])
    {
        if (isset($cron_config['max_cost'])){
            MonitorCustomAccountCost($cron_name, $cron_config, $CurrentConfig, $developer_token);
        }
    }
    else
    {
        MonitorAccountCost($service, $cron_name, $cron_config);
    }
}
else
{
    slecho("Cron type: Custom");
    $cron_config = isset($custom_dealerships[$cron_name])? $custom_dealerships[$cron_name] : false;

    if ($cron_config)
    {
        MonitorCustomAccountCost($cron_name, $cron_config, $CurrentConfig, $developer_token);
    }
}

slecho('END');
