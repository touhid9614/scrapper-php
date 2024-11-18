<?php

ini_set('display_errors', 1);
ini_set('memory_limit', -1);
error_reporting(E_ALL);

session_start();

require_once('config.php');
require_once('utils.php');
require_once('Google/Util.php');
require_once('cron_misc.php');
require_once('db_connect.php');


global $CronConfigs, $scrapper_configs, $connection;

$max_fb_crons = 1;

//set it to run for no timeout
echo("Trying to set timeout to no limit" . PHP_EOL);
set_time_limit(0);
echo("Maximum execution time: " . ini_get('max_execution_time') . PHP_EOL);

$start_time = time();

$time_saved = 0;

$db_connect = new DbConnect('');

$db_connect->create_meta_table('fbsync_run_state'); #this will do nothing if fbsync_run_state_meta_data exists

$last_cron_name = $db_connect->get_meta('fbsync_run_state', 'last_cron_name');
$start_next = $last_cron_name? (isset($scrapper_configs[$last_cron_name]) ? false : true) : true;
$broken = false;

if($last_cron_name)
{
    echo("Last cron was $last_cron_name\n");
    slecho("Last cron was $last_cron_name");
}

foreach ($scrapper_configs as $cron_name => $project_config)
{
    if(!isset($CronConfigs[$cron_name]) || !isset($CronConfigs[$cron_name]['fb_config'])) { continue; }

    $worker_list = explode("\n", `ps aux |  grep -i php | grep ng_fbsync_worker.php | grep -v grep | awk '{print $13}'`);

    $worker_count = count($worker_list) - 1;

    echo("Total fbsyncs running: $worker_count\n");
    slecho("Total fbsyncs running: $worker_count");

    if($worker_count >= $max_fb_crons)
    {
        $broken = true;
        break;
    }
    if(!$start_next)
    {
        if($last_cron_name == $cron_name)
        {
            $start_next = true;
        }
        continue;
    }

    if(!isset($CronConfigs[$cron_name]['fb_config']['targeting']))
    {
        slecho("ERROR: Scrapper cron does not have fbsync configuration. Skipping project '" . $cron_name . "'");
        continue;
    }

    if(!in_array($cron_name, $worker_list))
    {
        slecho("Starting cron for $cron_name");
        exec ('php '
                . escapeshellarg(__DIR__ . '/ng_fbsync_worker.php') . ' '
                . escapeshellarg($cron_name)
                . ' > /dev/null &');
    }
    else
    {
        slecho("Cron already running for $cron_name");
    }

    $db_connect->update_meta('fbsync_run_state', 'last_cron_name', $cron_name);
    $broken = true;
    break;                                                                      #TO reduce load start only one then return
}

if(!$broken)
{
    $db_connect->update_meta('fbsync_run_state', 'last_cron_name');
}

$db_connect->close_connection();
