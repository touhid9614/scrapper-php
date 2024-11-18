<?php

global $CronConfigs;
$CronConfigs["perfectionhondacom"] = array(
    "name" => " perfectionhondacom",
    "email" => "regan@smedia.ca",
    "password" => " perfectionhondacom",
    "log" => true,
    'combined_feed_mode' => true,
    'customer_id' => '556-026-3656',
    'max_cost' => 1000,
    'cost_distribution' => array(
        'youtube' => 1000,
),
    "banner" => array(
        "template" => "perfectionhondacom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);