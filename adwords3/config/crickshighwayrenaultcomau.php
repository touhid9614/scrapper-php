<?php
global $CronConfigs;
$CronConfigs["crickshighwayrenaultcomau"] = array( 
	"name"  =>" crickshighwayrenaultcomau",
	"email" => "regan@smedia.ca",
	"password" =>" crickshighwayrenaultcomau",
	"log" => true,
	'combined_feed_mode' => true,
	
	'fb_title' => "[year] [make] [model] [trim]",
	"banner" => array(
        "template" => "crickshighwayrenaultcomau",
        'fb_style' => 'facebook_raw_img',
		"fb_description" => "[description]",
		"fb_lookalike_description"	=> "[description]",
		//"fb_description_used" => "The Cricks Highway Renault Used Car Clearance is on!  For all of July you can score an unbeatable deal across a huge range of our Used Cars, just like this [year] [make] [model] [trim] for only [price] Drive Away*.  Tap below to explore this offer and many more!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);
