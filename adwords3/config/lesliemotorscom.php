<?php

global $CronConfigs;
$CronConfigs["lesliemotorscom"] = array(
    'name' => 'lesliemotorscom',
    'email' => 'regan@smedia.ca',
    'password' => 'lesliemotorscom',
    'log' => true,
    "combined_feed_mode" => true,
    'customer_id' => '522-417-1111',
    'max_cost' => 700,
    'cost_distribution' => array(
        'adwords' => 700,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'combined_feed_mode' => true,
    'referer' => false,
    'banner' => array(
        'template' => 'lesliemotorscom',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);