<?php
global $CronConfigs;
 $CronConfigs["allstarhonda"] = array( 
	"name"  =>" allstarhonda",
	"email" => "regan@smedia.ca",
	"password" =>" allstarhonda",
	"log" => true ,
	'combined_feed_mode' => true,
        'fb_brand' => '[year] [make] [model] - [body_style]',
	"banner" => array(
        "template" => "allstarhonda",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);