<?php

global $CronConfigs;
$CronConfigs["alwaysgreenturfcom"] = array(
    "name" => "alwaysgreenturfcom",
    "email" => "regan@smedia.ca",
    "password" => "alwaysgreenturfcom",
    "log" => true,
    'customer_id' => '859-642-0801',
    "combined_feed_mode" => true,
    'max_cost' => 10000,
    'cost_distribution' => array(
        'new' => 5000,
        'used' => 5000,
),
);