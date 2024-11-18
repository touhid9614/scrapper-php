<?php
global $CronConfigs;
$CronConfigs["raypricemazdacom"] = array( 
	"name"  =>" raypricemazdacom",
	"email" => "regan@smedia.ca",
	"password" =>" raypricemazdacom",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "raypricemazdacom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

