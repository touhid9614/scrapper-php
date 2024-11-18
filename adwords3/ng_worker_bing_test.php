<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$argv[1]    =   'mbregina';
$argv[2]    =   'marshal';

if(!isset($argv[2])) die('Nothing to do, need arguments.');


//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS'] = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes


$_GET['customer'] = $argv[2];
//$_GET['scrap'] = 'true';

print_r($argv);
$cron_name = $argv[1];

$worker_log_dir = __DIR__ . '/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $cron_name);

if(!file_exists($worker_log_dir)) {
    if(!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}


$worker_logfile = $worker_log_dir .'/'. date('Y-m-d_H:i:s_') .substr((string)microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

$cron_config = null;

function logme_nostrip($text)
{
    global $worker_logfile, $cron_config;
    if((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, $text."\n", FILE_APPEND);
    }
}

function logme($text)
{
    global $worker_logfile, $cron_config;
    if((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, strip_tags($text)."\n", FILE_APPEND);
    }
}

logme(print_r($argv, true));
logme('Starting thread');
$grepstring = 'ps aux  | grep -v grep | grep '. escapeshellarg('ng_worker.php '.$argv[1].' '.$argv[2]) .' | grep -v sudo';
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
require_once('utils.php');
require_once('Google/TokenHelper.php');
require_once('Google/Types.php');
require_once('Google/Util.php');
require_once('Google/Consts.php');
require_once('Google/Adwords.php');
require_once('Google/Analytics.php');
//require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('AdSyncer.php');
require_once('scrapper.php');

/*
 * For bing ads included these file
 */
require_once('bing/adSyncer.php');
require_once('bing/V12/myBingAds.php');

//Config resets errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting((E_ALL & ~E_NOTICE) & ~E_WARNING);

require_once('carlist-loader.php');

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
       $market_buyers, $SWFConfigs, $connection, $proxy_list, $area_proxy, $carlist, $advanced_carlist,
       $BannerConfigs, $number_of_retries;

//set it to run for no timeout
secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

loadCarList();  //load the carlist for smart scrapping
loadAdvancedCarList();

$start_time = time();

$scrapper_config = $scrapper_configs[$cron_name];

if(!$cron_config) {
    $cron_config = $CronConfigs[$cron_name];
}

if(isset($scrapper_config['use-proxy']) && $scrapper_config['use-proxy']) {
    $scrapper_config['proxy'] = isset($scrapper_config['proxy-area'])? $area_proxy[$scrapper_config['proxy-area']] : $proxy_list;
}

//adding number_of_retries to the config for scrapper
$scrapper_config['number_of_retries'] = $number_of_retries;

$lang = isset($cron_config['lang'])?$cron_config['lang']:'en';
if(!defined('adlang')) {
    define('adlang', $lang);
}

$mutex = Mutex::create();
/*
slecho("Starting scrapper cron for '" . $cron_name . "'");
Scrap(
    $cron_name,
    $cron_config,
    $scrapper_config,
    $CurrentConfig,
    $connection,
    $carlist,
    $advanced_carlist,
    $mutex
);

slecho("Starting sync cron for '" . $cron_name . "'");
SyncAd(
    $cron_name,
    $cron_config,
    $CurrentConfig,
    $developer_token,
    $market_buyers,
    $connection,
    $mutex,
    $SWFConfigs,
    $BannerConfigs);

*/

/*
 * Check bing ads applicable for this dealer or not, if applicable then call bing ads
 */
$db_connect             = new DbConnect($cron_name);
$dealership_details     = $db_connect->get_dealer_details($cron_name);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);
$file_path              =   __DIR__ . '/caches/bingads-log/' . $cron_name . '.txt';
if (in_array('Bing Ads', $dealership_details['campaign_types'])) {
    writeLog($file_path, "---------------Starting bing ads for '" . $cron_name . "'---------------");
    SyncBingAd($cron_name, $cron_config, $file_path);
}


Mutex::destroy($mutex);
mysqli_close($connection);
