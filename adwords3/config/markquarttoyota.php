<?php
global $CronConfigs;
 $CronConfigs["markquarttoyota"] = array( 
	"name"  =>" markquarttoyota",
	"email" => "regan@smedia.ca",
	"password" =>" markquarttoyota",
	"log" => true ,
	"fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "markquarttoyota",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			//"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
);