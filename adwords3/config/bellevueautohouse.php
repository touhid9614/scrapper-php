<?php
global $CronConfigs;
 $CronConfigs["bellevueautohouse"] = array( 
	"name"  =>" bellevueautohouse",
	"email" => "regan@smedia.ca",
	"password" =>" bellevueautohouse", 
	'fb_brand'          => '[year] [make] [model] - [body_style]',
	"log" => true ,
        "customer_id" => "884-096-4956",
        'max_cost' => 0,
     'cost_distribution' => array(
        'adwords' => 0,
    ),
    "create" => array(
        "used_search" => yes,
        "used_placement" => yes,
        "used_retargeting" => yes,
        "used_combined" => yes,
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
        "template" => "bellevueautohouse",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
		"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_style" => "facebook_new_ad",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
        ),
    ),
);