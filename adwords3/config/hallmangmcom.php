<?php

global $CronConfigs;
$CronConfigs["hallmangmcom"] = array(
    "name" => " hallmangmcom",
    "email" => "regan@smedia.ca",
    "password" => " hallmangmcom",
    "log" => true,
    // 'no_adv' => true,
    'combined_feed_mode' => true,
    'customer_id' => '764-426-4135',
    'max_cost' => 1700,
    'cost_distribution' => array(
        'adwords' => 1700,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => no,
        "used_placement" => no,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => no,
),
    "new_descs" => array(
        array(
            "title2" => "Take a Virtual Test Drive",
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "title2" => "Take a Virtual Test Drive",
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "title2" => "Take a Virtual Test Drive",
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "title2" => "Take a Virtual Test Drive",
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "banner" => array(
        "template" => "hallmangmcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'smart_banner' => array(
        'live' => true,
        'title' => 'Hallman Has It Too Make Us Your 1st & Last Stop ',
),
);