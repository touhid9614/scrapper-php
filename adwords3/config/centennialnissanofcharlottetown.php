<?php
global $CronConfigs;
 $CronConfigs["centennialnissanofcharlottetown"] = array( 
	"name"  =>" centennialnissanofcharlottetown",
	"email" => "regan@smedia.ca",
	"password" =>" centennialnissanofcharlottetown",
	"log" => true ,
	'bing_account_id' => 156003555,
	"create" => array(
        "new_search" => yes,
        "used_search" => yes,
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
	"fb_brand" => "[year] [make] [model] - [body_style]",
	   "banner" => array(
        "template" => "dealership",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model] Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);