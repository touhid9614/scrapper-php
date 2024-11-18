<?php

global $CronConfigs;
$CronConfigs["vacarswestbroadcom"] = array(
    "name" => " vacarswestbroadcom",
    "email" => "regan@smedia.ca",
    "password" => " vacarswestbroadcom",
    "log" => true,
    // 'tag_debug' => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "vacarswestbroadcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'customer_id' => '139-532-1060',
    'max_cost' => 545,
    'cost_distribution' => array(
        'adwords' => 545,
),
);