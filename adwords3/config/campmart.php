<?php
global $CronConfigs;
 $CronConfigs["campmart"] = array( 
	"name"  =>" campmart",
	"email" => "regan@smedia.ca",
	"password" =>" campmart",
	"log" => true ,
	"banner" => array(
        "template" => "campmart",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner"
        ),
    ),
);