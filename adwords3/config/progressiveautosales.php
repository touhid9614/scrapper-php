<?php
global $CronConfigs;
 $CronConfigs["progressiveautosales"] = array( 
	"name"  =>" progressiveautosales",
	"email" => "regan@smedia.ca",
	"password" =>" progressiveautosales",
	"log" => true ,
	"banner" => array(
        "template" => "progressiveautosales",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);