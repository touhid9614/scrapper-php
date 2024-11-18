<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(dirname(__DIR__));
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$dealer = $_GET['dealer'];

global $CronConfigs;

if (!$dealer) {
	foreach ($CronConfigs as $name => $file) {
		clearTagApiCache($name);
	}
} else {
	clearTagApiCache($dealer);
}