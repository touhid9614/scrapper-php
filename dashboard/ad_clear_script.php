<?php
session_start();
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

global $CronConfigs,$user;

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$dealers = [];

foreach ($CronConfigs as $cron_name => $cron_config)
{
	if (isset($cron_config['customer_id']))
	{
		$dealers[] = $cron_name;
	}
}

$done = file('done.txt', FILE_IGNORE_NEW_LINES);

$diff = array_diff($dealers, $done);

file_put_contents('done.txt', "n", FILE_APPEND);

foreach ($diff as $cron)
{
	exec ('/usr/local/bin/php ' 
    . escapeshellarg(ADSYNCPATH . 'ng_clear.php') . ' ' 
    . escapeshellarg($cron) . ' ' 
    . escapeshellarg('marshal') . ' ' 
    . escapeshellarg('0') . ' '
    . escapeshellarg("1")
    . ' > /dev/null 2>/dev/null &', $outputr);

    file_put_contents('done.txt', $cron, FILE_APPEND);
}