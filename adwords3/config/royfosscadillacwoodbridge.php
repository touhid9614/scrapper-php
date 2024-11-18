<?php

global $CronConfigs;
$CronConfigs["royfosscadillacwoodbridge"] = array(
    'password' => 'royfosscadillacwoodbridge',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 3300,
    'cost_distribution' => array(
        'adwords' => 3100,
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
    "bing_account_id" => '156003042',
    'customer_id' => '737-403-3149',
    "banner" => array(
        "template" => "royfosscadillacwoodbridge",
        //'fb_retargeting_description_new' => 'The Canada-Wide Clearance Event Continues! Come see the [year] [make] [model] today. Click for more info! Stock #- [stock_number]. [price]',
        'fb_retargeting_description' => 'Still interested in the [year] [make] [model]? Click for more info! Stock #- [stock_number]. [price]',
        //"fb_description_2018_xt5" => "Come see the [year] [make] [model] [trim] today. Click for more info! Stock #- [stock_number]. [price]",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Stock #- [stock_number]. [price]",
		"fb_democlearout_description" => "Check out this [year] [make] [model] today! Stock #- [stock_number]. [price]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
);