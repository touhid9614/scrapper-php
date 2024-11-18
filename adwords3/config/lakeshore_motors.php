<?php

global $CronConfigs;
$CronConfigs["lakeshore_motors"] = array(
    "name" => "lakeshore_motors",
    "password" => "lakeshore_motors",
    'log' => true,
    'customer_id' => '752-658-5970',
    'max_cost' => 400,
    'cost_distribution' => array(
        'adwords' => 400,
),
    "create" => array(
        "used_search" => yes,
        "used_placement" => yes,
        "used_display" => yes,
        "used_retargeting" => yes,
        "used_marketbuyers" => no,
        "used_combined" => yes,
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
    "banner" => array(
        "template" => "lakeshore_motors",
        "fb_description" => "Are you still interested in the [Year] [Make] [Model]? Click below for more info!",
        "fb_lookalike_description" => "Test drive the [Year] [Make] [Model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
),
);