<?php

global $CronConfigs;
$CronConfigs["planethonda"] = array(
    "name" => "planethonda",
    "email" => "regan@smedia.ca",
    "password" => "planethonda",
    'log' => true,
    'customer_id' => '699-511-7333',
        'max_cost' => 2000,
        'cost_distribution' => array(
        'adwords' => 2000,
        ),
    'combined_feed_mode' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "planethonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17599',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);