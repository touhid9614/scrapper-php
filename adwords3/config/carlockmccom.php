<?php
global $CronConfigs;
$CronConfigs["carlockmccom"] = array( 
	"name"  =>" carlockmccom",
	"email" => "regan@smedia.ca",
	"password" =>" carlockmccom",
	"log" => true,
	
	"banner" => array(
        "template" => "carlockmccom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);
