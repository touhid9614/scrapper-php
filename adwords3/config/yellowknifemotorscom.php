<?php

global $CronConfigs;
$CronConfigs["yellowknifemotorscom"] = array(
    "name" => " yellowknifemotorscom",
    "email" => "regan@smedia.ca",
    "password" => " yellowknifemotorscom",
    "log" => true,
    'customer_id' => '517-165-8307',
    "banner" => array(
        "template" => "yellowknifemotorscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 250,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'dynamic' => 200,
        'custom' => 50,
),
);