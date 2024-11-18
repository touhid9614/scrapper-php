<?php
global $CronConfigs;
 $CronConfigs["autoformco"] = array( 
	"name"  =>" autoformco",
	"email" => "regan@smedia.ca",
	"password" =>" autoformco",
	"log" => true ,
	"banner" => array(
        "template" => "autoformco",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

