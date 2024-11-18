<?php
global $CronConfigs;
$CronConfigs["maplemazdacom"] = array( 
	"name"  => "maplemazdacom",
	"email" => "regan@smedia.ca",
	"password" => "maplemazdacom",
	"log" => true,
    "combined_feed_mode" => true,
	
	"banner" => array(
        "template" => "maplemazdacom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

