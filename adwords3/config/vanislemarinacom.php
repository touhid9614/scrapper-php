<?php
global $CronConfigs;
$CronConfigs["vanislemarinacom"] = array( 
	"name"  => "vanislemarinacom",
	"email" => "regan@smedia.ca",
	"password" => "vanislemarinacom",
	"log" => true,
        "combined_feed_mode" => true,
	
	"banner" => array(
        "template" => "vanislemarinacom",
		"fb_description" => "Are you still interested in the [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

