<?php

global $CronConfigs;
$CronConfigs["mertinnissancom"] = array(
    "name" => " mertinnissancom",
    "email" => "regan@smedia.ca",
    "password" => " mertinnissancom",
    "log" => true,
    'combined_feed_mode' => true,
    "customer_id" => "161-219-9533",
    'max_cost' => 4500,
    'cost_distribution' => array(
        'new' => 1000,
        'custom' => 3500,
),
    "banner" => array(
        "template" => "mertinnissancom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);