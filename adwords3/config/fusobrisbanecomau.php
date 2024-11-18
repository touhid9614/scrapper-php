<?php
global $CronConfigs;
$CronConfigs["fusobrisbanecomau"] = array( 
	"name"  => "fusobrisbanecomau",
	"email" => "regan@smedia.ca",
	"password" => "fusobrisbanecomau",
	"log" => true,
        "combined_feed_mode" => true,
        'fb_title' => '[year] [make] [model] [trim]',
        "banner" => array(
                "template" => "fusobrisbanecomau",
                'fb_description' => "[year] [make] [model] [trim]",
                "flash_style" => "default",
                "border_color" => "#282828",
                "font_color" => "#ffffff",
        ),
);

