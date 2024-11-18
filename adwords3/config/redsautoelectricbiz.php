<?php
global $CronConfigs;
$CronConfigs["redsautoelectricbiz"] = array( 
	"name"  =>" redsautoelectricbiz",
	"email" => "regan@smedia.ca",
	"password" =>" redsautoelectricbiz",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "redsautoelectricbiz",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

