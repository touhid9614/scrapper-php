<?php

global $CronConfigs;
$CronConfigs["uppercanadamotors"] = array(
    'password' => 'uppercanadamotors',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "uppercanadamotors",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 50,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'youtube' => 50,
),
);