<?php

global $CronConfigs;
$CronConfigs["kirksvillemotorco"] = array(
    "name" => " kirksvillemotorco",
    "email" => "regan@smedia.ca",
    "password" => " kirksvillemotorco",
    'customer_id' => '251-137-1578',
    "log" => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "kirksvillemotorco",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 100,
    'cost_distribution' => array(
        'new' => 50,
        'used' => 50,
),
);