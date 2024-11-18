<?php
global $CronConfigs;
 $CronConfigs["hillsidechevrolet"] = array( 
	"name"  =>" hillsidechevrolet",
	"email" => "regan@smedia.ca",
	"password" =>" hillsidechevrolet",
	"log" => true ,
	'customer_id' => '511-357-7139',
	'cost_distribution' => array(
        'adwords' => 500,
	),
	"banner" => array(
        "template" => "hillsidechevrolet",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);