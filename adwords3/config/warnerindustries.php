<?php

global $CronConfigs;
$CronConfigs["warnerindustries"] = array(
    'name' => 'Warner Industries',
    'password' => 'warnerindustries',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 200,
    'youtube' => 125,
    "create" => array(
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
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
    'customer_id' => '441-306-3081',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "warnerindustries",
        'fb_description' => 'Click here to check out the [year] [make] [model] today !',
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#000000",
),
    'cost_distribution' => array(
        'new' => 100,
        'used' => 100,
),
);