<?php
global $CronConfigs;
 $CronConfigs["davesmithfordonline"] = array( 
	"name"  =>" davesmithfordonline",
	"email" => "regan@smedia.ca",
	"password" =>" davesmithfordonline",
	"log" => true ,
	"banner" => array(
        "template" => "davesmithfordonline",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
			//"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);