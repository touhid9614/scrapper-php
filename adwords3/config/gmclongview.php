<?php
global $CronConfigs;
 $CronConfigs["gmclongview"] = array( 
	"name"  =>" gmclongview",
	"email" => "regan@smedia.ca",
	"password" =>" gmclongview",
	"log" => true ,
	"banner" => array(
        "template" => "gmclongview",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);