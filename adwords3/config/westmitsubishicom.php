<?php
global $CronConfigs;
$CronConfigs["westmitsubishicom"] = array( 
	"name"  =>" westmitsubishicom",
	"email" => "regan@smedia.ca",
	"password" =>" westmitsubishicom",
	"log" => true,
	'max_cost' => 1000,
	'combined_feed_mode' => true,
    'cost_distribution' => array(
        'adwords' => 1000,
),
	'customer_id' => '679-593-3893',
	
	  "banner" => array(
        "template" => "dealership",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);

