<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

if (!isset($argv[2])) {
	die('Nothing to do, need arguments.');
}


//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS'] = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

$_GET['customer']   = $argv[2];

//print_r($argv);

$cron_name  = $argv[1];
$force      = ($argv[3] == '1');
$ads_type   = $argv[4];

$worker_log_dir = __DIR__ . '/ng_clear_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $cron_name);

if (!file_exists($worker_log_dir))
	if (!mkdir($worker_log_dir))
		die('can not create logging directory');


$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string)microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

function logme_nostrip($text)
{
	global $worker_logfile;
	file_put_contents($worker_logfile, $text . "\n", FILE_APPEND);
}

function logme($text)
{
	global $worker_logfile;
	file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
}

session_start();

logme(print_r($argv, true));
logme('Starting thread');
$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_clear.php ' . $argv[1] . ' ' . $argv[2] . ' ' . $argv[3]) . ' | grep -v sudo';
logme($grepstring);
logme(`$grepstring`);
if (`$grepstring | wc -l` > 1) {
	logme("already running, quitting");
	die();
} else {
	logme("Not already running");
}

require_once(__DIR__ . '/config.php');
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
require_once('bing/adSyncer.php');
require_once('bing/myBingAds.php');
require_once('scrapper.php');

global $CronConfigs, $connection;

//set it to run for no timeout
secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

$start_time = time();

$mutex = Mutex::create();

$cron_config = $CronConfigs[$cron_name];

switch ($ads_type) {
	case "1":
		slecho("Starting Google Ad cleaner cron for '" . $cron_name . "'");
		ClearAds($cron_name, $cron_config, $force);

		slecho("Starting data eraser cron for '" . $cron_name . "'");
		ClearScrap($connection, $cron_name, $mutex);
		break;
	case "2":
		slecho("Starting Google Ad cleaner cron for '" . $cron_name . "'");
		ClearAds($cron_name, $cron_config, $force);
		break;
	case "3":
		$log_file_path = __DIR__ . '/caches/bingads-log/clear-' . $cron_name . '.txt';
		writeLog($log_file_path, "Starting Bing Ad cleaner cron for '" . $cron_name . "'");
		clearBingAds($cron_name, $cron_config, $force);
		break;
	case "4":
		$log_file_path = __DIR__ . '/caches/bingads-log/clear-' . $cron_name . '.txt';
		writeLog($log_file_path, "Starting Bing Ad cleaner cron for '" . $cron_name . "'");
		clearFullBingAds($cron_name, $cron_config, $force);
		break;
	case "5":
		slecho("Starting data eraser cron for '" . $cron_name . "'");
		ClearScrap($connection, $cron_name, $mutex);
		break;
	default:
		slecho("Starting Google Ad cleaner cron for '" . $cron_name . "'");
		ClearAds($cron_name, $cron_config, $force);

		$log_file_path = __DIR__ . '/caches/bingads-log/' . $cron_name . '.txt';
		writeLog($log_file_path, "Starting Bing Ad cleaner cron for '" . $cron_name . "'");
		clearBingAds($cron_name, $cron_config, $force);

		slecho("Starting data eraser cron for '" . $cron_name . "'");
		ClearScrap($connection, $cron_name, $mutex);
}

Mutex::destroy($mutex);
mysqli_close($connection);

$elapced = time() - $start_time;
slecho("Info: Total time taken " . $elapced . "seconds");
