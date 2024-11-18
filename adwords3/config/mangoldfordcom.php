<?php
global $CronConfigs;
$CronConfigs["mangoldfordcom"] = array( 
	"name"  =>" mangoldfordcom",
	"email" => "regan@smedia.ca",
	"password" =>" mangoldfordcom",
	"log" => true,
	'combined_feed_mode' => true,
	'customer_id' => '334-441-2654',
        'max_cost' => 500,
        'cost_distribution' => array(
        'adwords' => 500,
        ),
	"banner" => array(
        "template" => "mangoldfordcom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

