<?php

global $CronConfigs;
$CronConfigs["hawkinschevrolet"] = array(
    "name" => " hawkinschevrolet",
    "email" => "regan@smedia.ca",
    "password" => " hawkinschevrolet",
    "log" => true,
    "banner" => array(
        "template" => "hawkinschevrolet",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17858',
        'promotion_text' => 'Get $200 off!',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);