<?php
global $CronConfigs;
$CronConfigs["centralkiaca"] = array( 
	"name"  => "centralkiaca",
	"email" => "regan@smedia.ca",
	"password" => "centralkiaca",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "centralkiaca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",

		 'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
		 
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

