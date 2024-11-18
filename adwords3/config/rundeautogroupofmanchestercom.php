<?php
global $CronConfigs;
$CronConfigs["rundeautogroupofmanchestercom"] = array( 
	"name"  =>" rundeautogroupofmanchestercom",
	"email" => "regan@smedia.ca",
	"password" =>" rundeautogroupofmanchestercom",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "rundeautogroupofmanchestercom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

