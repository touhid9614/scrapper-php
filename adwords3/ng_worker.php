<?php

$cron_start_time = time();

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

if (!isset($argv[2])) {
    die('Nothing to do, need arguments.');
}

global $single_config;

// emulate web variables for command line usage
// at the moment needed in an image generation function
$_SERVER['HTTPS']       = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value';
// this should work just fine for our purposes

$_GET['customer'] = $argv[2];

print_r($argv);
$cron_name = $single_config = $argv[1];

$worker_log_dir = __DIR__ . '/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $cron_name);
$global_logfile = __DIR__ . '/ng_logs/global_log.txt';

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

$cron_config = null;

function logme_nostrip($text)
{
    global $worker_logfile, $cron_config;

    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, $text . "\n", FILE_APPEND);
    }
}

function logme($text)
{
    global $worker_logfile, $cron_config;

    if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
        file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
    }
}

logme(print_r($argv, true));
logme('Starting thread');
$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_worker.php ' . $argv[1] . ' ' . $argv[2]) . ' | grep -v sudo';
logme($grepstring);
logme(`$grepstring`);

if (`$grepstring | wc -l` > 1) {
    logme("already running, quitting");
    die();
} else {
    logme("Not already running");
}

require_once 'config.php';
require_once dirname(__DIR__) . '/includes/init-db.php';
require_once 'utils.php';

// GOOGLE
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Consts.php';
require_once 'Google/Adwords.php';
require_once 'Google/Analytics.php';
require_once 'Google/SessionManager.php';

require_once 'cron_misc.php';
require_once 'db_connect.php';
require_once 'tag_db_connect.php';
require_once 'AdSyncer.php';
require_once 'scrapper.php';

// For bing ads included these file
require_once 'bing/adSyncer.php';
require_once 'bing/myBingAds.php';

// Config resets errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting((E_ALL & ~E_NOTICE) & ~E_WARNING);

require_once 'carlist-loader.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
    $market_buyers, $SWFConfigs, $proxy_list, $area_proxy, $carlist, $advanced_carlist,
    $BannerConfigs, $number_of_retries;

// set it to run for no timeout
secho("Trying to set timeout to no limit <br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

// load the carlist for smart scrapping
loadCarList();             // populates $carlist
loadAdvancedCarList();  // populates $advanced_carlist

$start_time      = time();
$scrapper_config = $scrapper_configs[$cron_name];

if (!$cron_config) {
    $cron_config = $CronConfigs[$cron_name];
}


if (isset($scrapper_config['use-proxy']) && $scrapper_config['use-proxy']) {
    $scrapper_config['proxy'] = isset($scrapper_config['proxy-area']) ? $area_proxy[$scrapper_config['proxy-area']] : $proxy_list;
}

// adding number_of_retries to the config for scrapper
$scrapper_config['number_of_retries'] = isset($scrapper_config['number_of_retries']) ? $scrapper_config['number_of_retries'] : $number_of_retries;
$lang = isset($cron_config['lang']) ? $cron_config['lang'] : 'en';

if (!defined('adlang')) {
    define('adlang', $lang);
}

$db_connect         = new DbConnect($cron_name);
$dealership_details = $db_connect->get_dealer_details($cron_name);

slecho("Starting scrapper cron for '" . $cron_name . "'");

$now_time_now = time();

try {
    $query = "UPDATE dealerships SET last_scrapped_at = {$now_time_now} WHERE dealership = '{$cron_name}';";
    $db_connect->query($query);
    slecho("Executed query: " . $query);
} catch (Exception $ex) {
    slecho("FAILED to store scrapping time in DB for {$cron_name}.");
}

Scrap($cron_name, $scrapper_config, $CurrentConfig, $carlist, $advanced_carlist);
// Notify smedia api about scraper complete
file_get_contents("https://tools.smedia.ca/APIs/dashboard/budget-sync.php?dealership=$cron_name");
file_get_contents("https://api.smedia.ca/v1/ads/scraper-complete/$cron_name");
clearTagApiCache($cron_name);

// After scrapping create snapchat feed cache
if ($dealership_details['snapchat_feed_export']) {
    $snapchat_feed_dir = __DIR__ . '/client-data/snapchat/';

    if (!is_dir($snapchat_feed_dir)) {
        mkdir($snapchat_feed_dir, 0777, true);
    }

    $snapchat_feed_file = "{$snapchat_feed_dir}{$cron_name}.csv";
    $snapchat_feed_url  = "https://tm.smedia.ca/snapchat-feed.php?dealership={$cron_name}";

    $feed = HttpGet($snapchat_feed_url);
    file_put_contents($snapchat_feed_file, $feed);
}

if (isset($CronConfigs[$cron_name]['bing_account_id']) && !empty($CronConfigs[$cron_name]['bing_account_id'])) {
    $bing_launch_str = 'php '
    . escapeshellarg(dirname(__DIR__) . '/services/bing-v2.php') . ' '
    . escapeshellarg($cron_name) . ' '
    . 'sync 2>&1';

    slecho("Launching new bing-v2");
    slecho($bing_launch_str);
    $output = null;
    $retval = null;
    exec($bing_launch_str, $output, $retval);

    $bing_exec_str = "ps aux | grep -i php | grep bing-v2.php | grep $cron_name | grep -v grep | awk '{print $2, $13}'";
    $bing_worker   = array_filter(explode(" ", exec($bing_exec_str)));
    slecho("Launch status bing-v2 " . json_encode($bing_worker));
    slecho("Return Value bing-v2 " . json_encode($retval));
    slecho("Output bing-v2");
    slecho(json_encode($output));
    slecho("\n\n\n");
}

// Check bing ads applicable for this dealer or not, if applicable then call bing ads
$file_path = __DIR__ . '/caches/bingads-log/' . $cron_name . '.txt';

SyncBingAd($cron_name, $cron_config, $file_path);


$cron_span = time() - $cron_start_time;

try {
    $query = "UPDATE dealerships SET scrapping_period = {$cron_span} WHERE dealership = '{$cron_name}';";
    $db_connect->query($query);
    slecho("Executed query: " . $query);
} catch (Exception $ex) {
    slecho("FAILED to store scrapping period in DB for {$cron_name}.");
}

$db_connect->close_connection();