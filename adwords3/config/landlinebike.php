<?php

global $CronConfigs;
$CronConfigs["landlinebike"] = array(
    "name" => "landlinebike",
    "email" => "regan@smedia.ca",
    "password" => "landlinebike",
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 202,
        'used' => 198,
),
    "banner" => array(
        "template" => "landlinebike",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);