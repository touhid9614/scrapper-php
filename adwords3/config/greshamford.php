<?php
global $CronConfigs;
 $CronConfigs["greshamford"] = array( 
	"name"  =>" greshamford",
	"email" => "regan@smedia.ca",
	"password" =>" greshamford",
	"log" => true ,
	"banner" => array(
        "template" => "greshamford",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);