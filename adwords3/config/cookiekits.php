<?php
global $CronConfigs;
 $CronConfigs["cookiekits"] = array( 
	"name"  =>" cookiekits",
	"email" => "regan@smedia.ca",
	"password" =>" cookiekits",
	"log" => true ,
	
	  "banner" => array(
        "template" => "cookiekits",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model] Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);