<?php

global $CronConfigs;
$CronConfigs["jonesfordbuckeye"] = array(
    "name" => " jonesfordbuckeye",
    "email" => "regan@smedia.ca",
    "password" => " jonesfordbuckeye",
    "log" => true,
    'combined_feed_mode' => true,
    "customer_id" => "948-053-4572",
    'max_cost' => 1200,
    'cost_distribution' => array(
        'adwords' => 1200,
),
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "jonesfordbuckeye",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);