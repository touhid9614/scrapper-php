<?php

global $CronConfigs;
$CronConfigs["harveyrvscom"] = array(
    "name" => "harveyrvscom",
    "email" => "regan@smedia.ca",
    "password" => "harveyrvscom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "harveyrvscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'customer_id'       => '278-635-1825',
    
    'max_cost' => 500,
    'cost_distribution' => array(
        'new' => 250,
        'used' => 250,
),
);