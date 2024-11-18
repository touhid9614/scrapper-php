<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

global $CronConfigs;

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/db-config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

$php_file = $base_dir . '/match-leads.php';
$csv_dir  = $base_dir . '/reports/directmail/';
$log_file = $adwords_dir . "/caches/directmail/directmail" . date("_Y_m_d_h_i_s") . ".log";

writeLog($log_file, "Running 'generate-directmail-report.php' file.");

foreach ($CronConfigs as $cron => $config) {
    if (isset($config['mail_retargeting']) && $config['mail_retargeting']['enabled']) {
        $client_id = $config['mail_retargeting']['client_id'];
        $outputr   = [];
        $return    = null;
        $csv_file  = $csv_dir . $cron . '.csv';

        $launch_str = 'php '
        . escapeshellarg($php_file) . ' '
        . escapeshellarg($csv_file) . ' '
        . escapeshellarg($client_id)
        . ' > /dev/null 2>/dev/null &';

        $sts = exec($launch_str, $outputr, $return);
    }
}