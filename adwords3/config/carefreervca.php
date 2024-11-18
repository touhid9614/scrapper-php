<?php

global $CronConfigs;
$CronConfigs["carefreervca"] = array(
    "name" => "carefreervca",
    "email" => "regan@smedia.ca",
    "password" => "carefreervca",
    'customer_id' => '696-080-0582',
    'bing_account_id' => 156004865,
    'fb_brand' => '[year] [make] [model] [trim]',
    'max_cost' => 2200,
    'cost_distribution' => array(
        'adwords' => 2200,
),
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "carefreervca",
        "fb_banner_title" => '[year] [make] [model] [trim]',
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);