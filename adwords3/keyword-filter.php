<?php

exit();

# Filters are turned off for now 27th June 2019
# (Discussed with Anand to come up with new rules as existing rules appear not to work)

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
require_once('Google/Analytics.php');
require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('utils.php');
require_once('AdSyncer.php');
require_once('scrapper.php');

global $CronConfigs, $connection;

//set it to run for no timeout
slecho("Trying to set timeout to no limit");
set_time_limit(0);
slecho("Maximum execution time: " . ini_get('max_execution_time'));
slecho("");

$start_time = time();

$mutex = Mutex::create();

foreach ($CronConfigs as $cron_name => $cron_config) {
	slecho("Starting Keyword filter for '" . $cron_name . "'");
	slecho("");
	FilterKeywords($connection, $cron_name, $cron_config, $mutex);
}

Mutex::destroy($mutex);
mysqli_close($connection);

$elapced = time() - $start_time;
slecho("");
slecho("Info: Total time taken " . $elapced . "seconds");
