<?php
global $CronConfigs;
 $CronConfigs["barkermitsubishi"] = array( 
	"name"  =>" barkermitsubishi",
	"email" => "regan@smedia.ca",
	"password" =>" barkermitsubishi",
	"log" => true ,
	//'combined_feed_mode' => true,
	"banner" => array(
        "template" => "barkermitsubishi",
		"fb_description" => "Are you still interested in this [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);