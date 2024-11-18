<?php

global $CronConfigs;
$CronConfigs["badlandshdcom"] = array(
    "name" => "badlandshdcom",
    "email" => "regan@smedia.ca",
    "password" => "badlandshdcom",
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "badlandshdcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Test Ride It Today!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 500,
    'cost_distribution' => array(),
);