<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

global $redis, $redis_config;

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/db-config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

use Predis\Client as RedisClient;

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

