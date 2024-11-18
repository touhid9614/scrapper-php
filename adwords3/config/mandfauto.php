<?php

global $CronConfigs;
$CronConfigs["mandfauto"] = array(
    "name" => " mandfauto",
    "email" => "regan@smedia.ca",
    "password" => " mandfauto",
    "log" => true,
    "customer_id" => "137-334-1144",
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 1000,
),
    "create" => array(
        "new_search" => no,
        "used_search" => no,
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
        "template" => "mandfauto",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);