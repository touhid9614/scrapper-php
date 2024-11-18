<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

if (!isset($argv[1])) {
    if (isset($_GET['host'])) {
        $argv[1] = $_GET['host'];
    } else {
        die('Nothing to do, need arguments.');
    }
}

//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS']       = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

$argv[2] = true;

print_r($argv);
$host = $argv[1];

$worker_logfile = __DIR__ . '/logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $host) . '.log';

ini_set("error_log", $worker_logfile);

/**
 * { function_description }
 *
 * @param      <type>  $text   The text
 */
function logme_nostrip($text)
{
    global $worker_logfile;
    //file_put_contents($worker_logfile, $text."\n", FILE_APPEND);
}

/**
 * { function_description }
 *
 * @param      <type>  $text   The text
 */
function logme($text)
{
    global $worker_logfile;
    //file_put_contents($worker_logfile, strip_tags($text)."\n", FILE_APPEND);
}

logme(print_r($argv, true));
logme('Starting thread');
$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_scrap_cars.php ' . $host) . ' | grep -v sudo | grep -v root';
logme($grepstring);
logme(`$grepstring`);

if (`$grepstring | wc -l` > 1) {
    logme("already running, quitting");
    die();
} else {
    logme("Not already running");
}

require_once 'bootstrapper.php';

global $db_config, $connection, $carlist, $advanced_carlist, $site_scrappers, $tolog, $proxy_list, $site_rules;

loadCarList();
loadAdvancedCarList();

$mutex = Mutex::create();

$db_connect = new DbConnect('all_imported');

$dealership = $db_connect->get_imported_dealership($host);

if (!$dealership['rule_matched'] || !$dealership['scrapper_matched']) {
    slecho("No matching scrapper for $host");
    die();
}

$rule_name = $dealership['rule_name'];

#Logfile specific under rule/host
$worker_log_dir = __DIR__ . '/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $rule_name);

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_log_dir = $worker_log_dir . '/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $host);

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';
#End Logfile

if (!isset($site_rules[$rule_name])) {
    slecho("Scrapper config for provider $scrapper_name is not present");
    die();
}

if (($rule_name != 'autotrader') || (isset($dealership['status']['status']) && $dealership['status']['status'] == 'SUCCESS')) {
    die();
}

if (isset($dealership['address']['country_code']) && $dealership['address']['country_code'] == 'CA') {
    $scrappers = $site_rules[$rule_name]['scrapper'];

    slecho("Scrapping $host");
    $tdb_connect = new ThreadedDbConnect('all_imported', $connection, $mutex);
    ScrapCars($host, $dealership, $scrappers, $site_scrappers, $proxy_list, $tdb_connect, $carlist, $advanced_carlist);
}

Mutex::destroy($mutex);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

slecho('************************* THE END *************************');
