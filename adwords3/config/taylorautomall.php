<?php

global $CronConfigs;
$CronConfigs["taylorautomall"] = array(
    "name" => "taylorautomall",
    "email" => "regan@smedia.ca",
    "password" => "taylorautomall",
    'bing_account_id' => '156003552',
    "customer_id" => "353-094-0748",
    'max_cost' => 1150,
    'cost_distribution' => array(
        'adwords' => 1150,
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
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "log" => true,
    "banner" => array(
        "template" => "taylorautomall",
        "fb_description" => "Are you interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);