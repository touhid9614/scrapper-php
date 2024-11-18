<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $redis, $redis_config;

use Predis\Client as RedisClient;

if (!$redis) {
	$redis = new RedisClient($redis_config);
}


$daat = $redis->get('data_backfill_5fb6c66194138d001dfde56a');
print_r($daat);