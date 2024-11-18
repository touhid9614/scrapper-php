<?php
global $CronConfigs;
 $CronConfigs["autogalleryofwinnipeg"] = array( 
	"name"  =>" autogalleryofwinnipeg",
	"email" => "regan@smedia.ca",
	"password" =>" autogalleryofwinnipeg",
	"log" => true ,
    'combined_feed_mode' => true,
       "customer_id"   => "453-629-0425",
     'max_cost'      => 300,
    'cost_distribution' => array(
        'youtube'      => 300,
    ),
	
	  "banner" => array(
        "template" => "autogalleryofwinnipeg",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);