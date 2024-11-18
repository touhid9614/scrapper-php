<?php
global $CronConfigs;
 $CronConfigs["westernautoimports"] = array( 
	"name"  =>" westernautoimports",
	"email" => "regan@smedia.ca",
	"password" =>" westernautoimports",
	"log" => true ,
        'customer_id' => '395-448-1250',
    'max_cost' => 300 ,
    'cost_distribution' => array(
        'adwords' => 300 ,
    ),
    "create" => array(
        "new_search" => no,
        "used_search" => yes,
        "new_placement" => no,
        "used_placement" => yes,
        "new_retargeting" => no,
        "used_retargeting" => yes,
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
    "banner" => array(
        "template" => "drummondmotors",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
        "font_color" => "#ffffff",
    ),
	
);