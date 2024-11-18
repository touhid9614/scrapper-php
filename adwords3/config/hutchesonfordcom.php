<?php
global $CronConfigs;
$CronConfigs["hutchesonfordcom"] = array( 
	"name"  =>" hutchesonfordcom",
	"email" => "regan@smedia.ca",
	"password" =>" hutchesonfordcom",
	"log" => true,
	'combined_feed_mode' => true,
	
	  "banner" => array(
        "template" => "utchesonfordcom",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);

