<?php

global $CronConfigs;
$CronConfigs["barriemitsubishica"] = array(
    "name" => " barriemitsubishica",
    "email" => "regan@smedia.ca",
    "password" => " barriemitsubishica",
    "log" => true,
    'max_cost' => 490,
    'cost_distribution' => array(
        'adwords' => 490,
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
    'customer_id' => '494-660-9962',
    "banner" => array(
        "template" => "barriemitsubishica",
        "fb_description" => "Buy this [year] [make] [model] for [price] or finance at [finance] bi-weekly for 84 months!",
        //"fb_lookalike_description" => "Check out this [year] [make] [model] today. Click for more information.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);