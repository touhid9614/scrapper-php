<?php
global $CronConfigs;
$CronConfigs["regesterchevrolet"] = array(
    "name" => " regesterchevrolet",
    "email" => "regan@smedia.ca",
    "password" => " regesterchevrolet",
    "log" => true,
    'max_cost' => 1500,
    'cost_distribution' => array(
        'new' => 750,
        'used' => 750,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => no,
        "used_placement" => no,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
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

    'customer_id' => '569-979-6088',
	"banner" => array(
        "template" => "regesterchevrolet",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
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
        "font_color" => "#ffffff"
    ),
);