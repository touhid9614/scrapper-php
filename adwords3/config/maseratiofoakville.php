<?php

global $CronConfigs;
$CronConfigs["maseratiofoakville"] = array(
    "name" => " maseratiofoakville",
    "email" => "regan@smedia.ca",
    "password" => " maseratiofoakville", 'fb_brand'          => '[year] [make] [model] - [body_style]',
    "log" => true,
    'customer_id' => '105-659-3927',
    'max_cost' => 300.0,
    'cost_distribution' => array(
        'adwords' => 300,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_combined" => yes,
        "used_combined" => yes
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
        "template" => "maseratiofoakville",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
		"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner"
        ),
        "font_color" => "#ffffff"
    ),
);
