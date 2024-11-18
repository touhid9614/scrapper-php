<?php

exit();

# Filters are turned off for now 27th June 2019
# (Discussed with Anand to come up with new rules as existing rules appear not to work)

session_start();

require_once('config.php');
require_once('Google/TokenHelper.php');
require_once('Google/Types.php');
require_once('Google/Util.php');
require_once('Google/Adwords.php');
require_once('Google/Consts.php');
require_once('Google/SessionManager.php');
require_once('cron_misc.php');
require_once('utils.php');
require_once('AdSyncer.php');
require_once('scrapper.php');

global $CronConfigs;

//set it to run for no timeout
slecho("Trying to set timeout to no limit");
set_time_limit(0);
slecho("Maximum execution time: " . ini_get('max_execution_time'));
slecho("");

$start_time = time();

foreach ($CronConfigs as $cron_name => $cron_config) {
	slecho("Starting AdGroup filter for '" . $cron_name . "'");
	slecho("");
	FilterAdGroups($cron_name, $cron_config);
}

$elapced = time() - $start_time;
slecho("");
slecho("Info: Total time taken " . $elapced . "seconds");
