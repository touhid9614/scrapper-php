<?php
global $CronConfigs;
$CronConfigs["northedmontonkiacom"] = array( 
	"name"  =>" northedmontonkiacom",
	"email" => "regan@smedia.ca",
	"password" =>" northedmontonkiacom",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "northedmontonkiacom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

