<?php

global $CronConfigs;
$CronConfigs["mertingmcom"] = array(
    "name" => " mertingmcom",
    "email" => "regan@smedia.ca",
    "password" => " mertingmcom",
    "log" => true,
    'combined_feed_mode' => true,
    "customer_id" => "176-485-6394",
    //budget updated
    'max_cost' => 6700,
    'cost_distribution' => array(
        'new' => 6700,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
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
    "banner" => array(
        "template" => "mertingmcom",
        "fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] [trim] today! Click for more information.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);