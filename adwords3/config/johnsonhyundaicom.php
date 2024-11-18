<?php
global $CronConfigs;
$CronConfigs["johnsonhyundaicom"] = array( 
	"name"  =>" johnsonhyundaicom",
	"email" => "regan@smedia.ca",
	"password" =>" johnsonhyundaicom",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "johnsonhyundaicom",
		"fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] [trim] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

