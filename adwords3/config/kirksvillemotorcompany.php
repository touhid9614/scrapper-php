<?php

global $CronConfigs;
$CronConfigs["kirksvillemotorcompany"] = array(
    "name" => " kirksvillemotorcompany",
    "email" => "regan@smedia.ca",
    "password" => " kirksvillemotorcompany",
    'customer_id' => '389-534-3741',
    "log" => true,
    "fb_title" => "[year] [make] [model] - [price]",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "kirksvillemotorcompany",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    'max_cost' => 100,
    'cost_distribution' => array(
        'new' => 50,
        'used' => 50,
),
);