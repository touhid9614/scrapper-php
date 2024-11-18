<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS']       = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

$argv[2]        = true; //force loging
$worker_log_dir = __DIR__ . '/logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', 'scrapper-launcher');

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

/**
 * { function_description }
 *
 * @param      string  $text   The text
 */
function logme_nostrip($text)
{
    global $worker_logfile;
    file_put_contents($worker_logfile, $text . "\n", FILE_APPEND);
}

/**
 * { function_description }
 *
 * @param      <type>  $text   The text
 */
function logme($text)
{
    global $worker_logfile;
    file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
}

require_once 'bootstrapper.php';

$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_scrap_cars_launcher.php') . ' | grep -v sudo | grep -v root';

if (`$grepstring | wc -l` > 1) {
    slecho('An instance is already running.');
    slecho(`$grepstring`);
    slecho(`$grepstring | wc -l`);
    slecho('Quiting');
    die();
}

global $db_config, $connection, $carlist, $advanced_carlist, $site_scrappers, $tolog, $proxy_list, $site_rules, $max_crons;

loadCarList();
loadAdvancedCarList();

$db_connect = new DbConnect('all_imported');

$db_connect->create_meta_table('cron_run_state'); #this will do nothing if cron_run_state_meta_data exists

$last_website_id = $db_connect->get_meta('cron_run_state', 'last_website_id');

if (!$last_website_id) {
    $last_website_id = 0;
}

$my_max = intval($max_crons * 2.5);

$start = 0;
$count = $my_max;

slecho('************************* Car Scrapper *************************');
slecho("Maximum simultenous scrappers $my_max");

$where       = " id > $last_website_id AND address LIKE '%\"country\";s:6:\"Canada\"%'";
$dealerships = $db_connect->get_imported_dealerships($start, $count, $where);
$read        = count($dealerships);
$broken      = false;

while ($read > 0) {
    foreach ($dealerships as $dealership) {
        $worker_list            = explode("\n", `ps aux |  grep -i php | grep ng_worker.php | grep -v grep | grep -v root | awk '{print $13}'`);
        $thirdparty_worker_list = explode("\n", `ps aux |  grep -i php | grep ng_scrap_cars.php | grep -v grep | grep -v root | awk '{print $13}'`);

        $worker_count            = count($worker_list) - 1;
        $thirdparty_worker_count = count($thirdparty_worker_list) - 1;
        $crons_running           = $worker_count + $thirdparty_worker_count;

        slecho("Total crons running: $crons_running of which $worker_count are customers and $thirdparty_worker_count are others");

        if ($crons_running >= $my_max) {
            $broken = true;
            break;
        }

        $host = $dealership['host_name'];

        if (!$dealership['rule_matched'] || !$dealership['scrapper_matched']) {
            slecho("No matching scrapper for $host");
            continue;
        }

        $rule_name = $dealership['rule_name'];

        if (!isset($site_rules[$rule_name])) {
            slecho("Scrapper config for provider $scrapper_name is not present");
            continue;
        }

        if (($rule_name != 'autotrader') || (isset($dealership['status']['status']) && $dealership['status']['status'] == 'SUCCESS')) {
            continue;
        }

        if (isset($dealership['address']['country_code']) && $dealership['address']['country_code'] == 'CA') {
            if (!in_array($host, $thirdparty_worker_list)) {
                slecho("Starting cron for host $host");
                exec('/usr/local/bin/php '
                    . escapeshellarg(__DIR__ . '/ng_scrap_cars.php') . ' '
                    . escapeshellarg($host)
                    . ' > /dev/null &');
            } else {
                slecho("Cron already running for host $host");
            }

            $db_connect->update_meta('cron_run_state', 'last_website_id', $dealership['id']);
        }
    }

    if (date('G') > 6) {
        $time = date("H:i:s");
        slecho("Retiring for the day current time is $time");
        break;
    }

    if (!$broken) {
        $start += $read;
        $dealerships = $db_connect->get_imported_dealerships($start, $count, $where);
        $read        = count($dealerships);
    }
}

if ($read == 0) {
    $db_connect->update_meta('cron_run_state', 'last_website_id');
}

$db_connect->close_connection();

slecho('************************* THE END *************************');
