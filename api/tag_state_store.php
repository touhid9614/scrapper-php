<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once dirname(__DIR__) . '/vendor/autoload.php';
use Predis\Client as RedisClient;

$adwords_dir = dirname(__DIR__) . "/adwords3";

global $redis, $redis_config;

require_once $adwords_dir . '/db-config.php';

$cron_name       = filter_input(INPUT_POST, 'cron_name');
$page_type       = filter_input(INPUT_POST, 'page_type');
$view_content    = filter_input(INPUT_POST, 'view_content');
$mongo_dealer_id = filter_input(INPUT_POST, 'mongo_dealer_id');

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

$two_days = 172800; // 2 * 24 * 60 * 60

$tag_state_key = "tag_state_{$cron_name}_any";
$redis->set($tag_state_key, time());
$redis->expire($tag_state_key, $two_days);

if ($page_type != 'other') {
    $tag_state_page_key = "tag_state_{$cron_name}_{$page_type}";
    $redis->set($tag_state_page_key, time());
    $redis->expire($tag_state_page_key, $two_days);
}

if ($view_content) {
    $tag_state_viewcontent_key = "tag_state_{$cron_name}_vc";
    $redis->set($tag_state_viewcontent_key, time());
    $redis->expire($tag_state_viewcontent_key, $two_days);
}

if ($mongo_dealer_id) {
    $tag_load_key = "tag_load_{$mongo_dealer_id}";
    $redis->set($tag_load_key, time());
    $redis->expire($tag_load_key, $two_days);
}

echo json_encode(['success' => true]);