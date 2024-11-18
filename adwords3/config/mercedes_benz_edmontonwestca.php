<?php
global $CronConfigs;
 $CronConfigs["mercedes_benz_edmontonwestca"] = array( 
	"name"  =>" mercedes_benz_edmontonwestca",
	"email" => "regan@smedia.ca",
	"password" =>" mercedes_benz_edmontonwestca",
	"log" => true ,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "mercedes_benz_edmontonwestca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today. Click for more information.",
		"fb_style" => "fb_new_rightsidebar",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

