<?php
global $CronConfigs;
$CronConfigs["gobencarscom"] = array( 
	"name"  =>" gobencarscom",
	"email" => "regan@smedia.ca",
	"password" =>" gobencarscom",
	"log" => true,
	'combined_feed_mode' => true,
        'customer_id' => '148-106-8698',
	'max_cost' => 250,
        'cost_distribution' => array(
        'adwords' => 250,
        ),
	 "banner" => array(
        "template" => "gobencarscom",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);
