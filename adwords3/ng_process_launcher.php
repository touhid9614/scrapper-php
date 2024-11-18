<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);
error_reporting(E_ALL);

$customer = filter_input(INPUT_GET, 'customer');

if (!$customer && isset($argv[1])) {
    $customer = $argv[1];
}

if (!$customer) {
    die('Please specify one argument, the customer. example: php ng_process_launcher.php murry');
} else {
    echo "Customer: {$customer}\n";
}

$_GET['customer'] = $customer;

$argv[2] = true;
session_start();

$worker_logfile = __DIR__ . '/ng_logs/ng_process_log/' . date('Y-m-d', time()) . '.log';

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

ini_set("error_log", $worker_logfile);

echo "Starting for customer'{$_GET['customer']}' at " . date('d-M-Y H:i:s', time()) . "\n";

require_once 'config.php';
require_once 'utils.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Adwords.php';
require_once 'Google/Consts.php';
require_once 'Google/SessionManager.php';
require_once 'cron_misc.php';
require_once 'AdSyncer.php';
require_once 'scrapper.php';
require_once 'carlist-loader.php';
require_once 'db-config.php';
require_once 'db_connect.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
$market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist,
$BannerConfigs, $max_crons;

// set it to run for no timeout
echo ("Trying to set timeout to no limit" . PHP_EOL);
set_time_limit(0);
echo ("Maximum execution time: " . ini_get('max_execution_time') . PHP_EOL);

$start_time = time();
$time_saved = 0;

$db_connect  = new DbConnect('');
$res         = $db_connect->query("SELECT dealership FROM dealerships WHERE status IN ('active', 'trial') ORDER BY last_scrapped_at ASC, status ASC LIMIT 9;");
$run_dealers = [];

while ($row = mysqli_fetch_assoc($res)) {
    $run_dealers[] = $row['dealership'];
}

file_put_contents($worker_logfile, "\nTime:" . date('Y-m-d H:i:s P e', time()) . "\n", FILE_APPEND);
file_put_contents($worker_logfile, print_r($run_dealers, true), FILE_APPEND);

$cron_names = array_intersect(array_keys($scrapper_configs), array_keys($CronConfigs));

echo "Total Crons " . count($cron_names) . "\n";
slecho("Total Crons " . count($cron_names) . "\n");

$max_ng_workers = $max_crons;

// max 6 dealers are launched
foreach ($run_dealers as $cron_name) {
    $project_config         = $scrapper_configs[$cron_name];
    $worker_list            = explode("\n", `ps aux |  grep -i php | grep ng_worker.php | grep -v grep | awk '{print $13}'`);
    $thirdparty_worker_list = explode("\n", `ps aux |  grep -i php | grep ng_scrap_cars.php | grep -v grep | awk '{print $2}'`);

    $worker_count            = count($worker_list) - 1;
    $thirdparty_worker_count = count($thirdparty_worker_list) - 1;
    $crons_running           = $worker_count + $thirdparty_worker_count;

    echo ("Total crons running: {$crons_running} of which {$worker_count} are customers and {$thirdparty_worker_count} are others.\n");
    slecho("Total crons running: {$crons_running} of which {$worker_count} are customers and {$thirdparty_worker_count} are others.");

    if (!isset($CronConfigs[$cron_name])) {
        echo ("ERROR: Cron config unavailable for {$cron_name}. Skipping project '" . $cron_name . "'\n");
        slecho("ERROR: Cron config unavailable for {$cron_name}. Skipping project '" . $cron_name . "'");
        continue;
    }

    if ($crons_running >= $max_ng_workers) {
        echo ("Running maximum number of crons: {$max_ng_workers}\n");
        slecho("Running maximum number of crons: {$max_ng_workers}");
        break;
    }

    if (!in_array($cron_name, $worker_list)) {
        echo ("Starting cron for {$cron_name}\n");
        slecho("Starting cron for {$cron_name}");

        $script = 'php '
        . escapeshellarg(__DIR__ . '/ng_worker.php') . ' '
        . escapeshellarg($cron_name) . ' '
        . escapeshellarg($customer) . ' '
        . '> /dev/null &';

        // echo "{$script}\n";
        exec($script);
        $worker_list[] = $cron_name;
    } else {
        echo ("Cron already running for {$cron_name}.\n");
        slecho("Cron already running for {$cron_name}.");
        $now_time_now = time();
        $query        = "UPDATE dealerships SET last_scrapped_at = {$now_time_now} WHERE dealership = '{$cron_name}';";
        $db_connect->query($query);
        slecho("Executed query: " . $query);
    }

    sleep(10);
}

$db_connect->close_connection();