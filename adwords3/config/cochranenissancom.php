<?php
global $CronConfigs;
$CronConfigs["cochranenissancom"] = array( 
	"name"  =>" cochranenissancom",
	"email" => "regan@smedia.ca",
	"password" =>" cochranenissancom",
	"log" => true,
	'max_cost' => 0.1,
    
     'customer_id' => '217-451-6845',
    "create" => array(
        'new_search' => true,
        'used_search' => true,
        'new_placement' => true,
        'used_placement' => true,
        'new_display' => true,
        'used_display' => true,
        'new_retargeting' => true,
        'used_retargeting' => true,
        'new_marketbuyers' => false,
        'used_marketbuyers' => false,
        'new_combined' => true,
        'used_combined' => true,
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
        "template" => "cochranenissancom",
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
        "font_color" => "#ffffff"
    ),
);

