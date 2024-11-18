<?php
global $CronConfigs;
$CronConfigs["frankletaacuracom"] = array( 
	"name"  =>" frankletaacuracom",
	"email" => "regan@smedia.ca",
	"password" =>" frankletaacuracom",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "frankletaacuracom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

