<?php
global $CronConfigs;
$CronConfigs["marshallusedcarsca"] = array( 
	"name"  =>" marshallusedcarsca",
	"email" => "regan@smedia.ca",
	"password" =>" marshallusedcarsca",
	"log" => true,
	'customer_id' => '712-239-6329',
	'combined_feed_mode' => true,
	'max_cost' => 168,
    'cost_distribution' => array(
        'adwords' => 168,
	),
	
	"banner" => array(
        "template" => "marshallusedcarsca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

