<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);

$base_dir = dirname(dirname(__DIR__));
$adwords_dir = "$base_dir/adwords3/";
$process_redshift = "$base_dir/sale-prediction/process-redshift/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db-config.php';
require_once $process_redshift . 'ConnectMysql.php';
require_once $process_redshift . 'ConnectRedShift.php';
require_once $process_redshift . 'commonFunction.php';
require_once $process_redshift . 'statisticFunction.php';

