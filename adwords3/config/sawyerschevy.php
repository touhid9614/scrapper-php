<?php

global $CronConfigs;
$CronConfigs["sawyerschevy"] = array(
    'password' => 'sawyerschevy',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 2300,
    'per_vehicle_max_cost'  => 150,
    'cost_distribution' => array(
        'adwords' => 2300,
    ),
    "create" => array(
        "used_search" => yes,
        "new_search" => yes,
        "used_placement" => yes,
        "new_placement" => yes,
        "used_display" => no,
        "new_display" => no,
        "used_retargeting" => yes,
        "new_retargeting" => yes,
        "used_marketbuyers" => no,
        "new_marketbuyers" => no,
        "used_combined" => yes,
        "new_combined" => yes,
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
    'customer_id' => '405-598-3335',
    "banner" => array(
        "template" => "sawyerschevy",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17605',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);