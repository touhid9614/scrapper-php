<?php
global $CronConfigs;
 $CronConfigs["tandthonda"] = array( 
	"name"  =>" tandthonda",
	"email" => "regan@smedia.ca",
	"password" =>" tandthonda", 'fb_brand'          => '[year] [make] [model] - [body_style]',
	"log" => true ,
	"banner" => array(
        "template" => "tandthonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);