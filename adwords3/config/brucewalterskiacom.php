<?php

global $CronConfigs;
$CronConfigs["brucewalterskiacom"] = array(
    "name" => " brucewalterskiacom",
    "email" => "regan@smedia.ca",
    "password" => " brucewalterskiacom",
    "log" => true,
    'max_cost' => 1000.0,
    'cost_distribution' => array(
        'adwords' => 1000,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => no,
        "new_placement" => yes,
        "used_placement" => no,
        "new_display" => yes,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => no,
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
    "customer_id" => "275-246-9421",
    "banner" => array(
        "template" => "brucewalterskiacom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "old_price_new" => "msrp",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
        ),
    ),
);

