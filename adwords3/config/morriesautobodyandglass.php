<?php
global $CronConfigs;
 $CronConfigs["morriesautobodyandglass"] = array( 
	"name"  =>" morriesautobodyandglass",
	"email" => "regan@smedia.ca",
	"password" =>" morriesautobodyandglass",
	"log" => true ,
        'max_cost' => 100,
        'cost_distribution' => array(
        'adwords' => 100,
        ),
    "create" => array(
        "new_search" => no,
        "used_search" => yes,
        "new_placement" => no,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => yes,
        "new_retargeting" => no,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
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
    'customer_id' => '591-941-0460',
     "banner" => array(
        "template" => "morriesautobodyandglass",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today.",
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