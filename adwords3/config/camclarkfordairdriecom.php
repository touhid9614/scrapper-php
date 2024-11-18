<?php

global $CronConfigs;
$CronConfigs["camclarkfordairdriecom"] = array(
    "name" => " camclarkfordairdriecom",
    "email" => "regan@smedia.ca",
    "password" => " camclarkfordairdriecom",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "camclarkfordairdriecom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 1000,
    ),
);