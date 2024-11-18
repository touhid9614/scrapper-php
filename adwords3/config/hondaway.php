<?php

global $CronConfigs;
$CronConfigs["hondaway"] = array(
    "name" => " hondaway",
    "email" => "regan@smedia.ca",
    "password" => " hondaway",
    "log" => true,
    'customer_id' => '471-138-0194',
    "banner" => array(
        "template" => "hondaway",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 2000,
    'cost_distribution' => array(
        'new' => 350,
        'used' => 350,
        'dynamic' => 300,
        'custom' => 1000,
),
);