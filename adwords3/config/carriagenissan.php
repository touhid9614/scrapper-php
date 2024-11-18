<?php

global $CronConfigs;
$CronConfigs["carriagenissan"] = array(
    "name" => " carriagenissan",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "email" => "regan@smedia.ca",
    "password" => " carriagenissan",
    "log" => true,
    'customer_id' => '601-996-3941',
    'max_cost' => 4000,
    'cost_distribution' => array(
        'adwords' => 4000,
),
    "banner" => array(
        "template" => "carriagenissan",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17678',
        'promotion_text' => 'VISIT US TODAY!',
        'promotion_color' => '#C72035',
        'overlay_color' => '#C72035',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#C72035',
        'coupon_validity' => '30',
),
);