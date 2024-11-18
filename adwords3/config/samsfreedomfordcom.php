<?php
global $CronConfigs;
$CronConfigs["samsfreedomfordcom"] = array( 
	"name"  =>" samsfreedomfordcom",
	"email" => "regan@smedia.ca",
	"password" =>" samsfreedomfordcom",
	'combined_feed_mode' => true,
	"log" => true,
	'customer_id' => '558-893-7276',
	'max_cost' => 386,
        'cost_distribution' => array(
        'adwords' => 386,
        ),
	
	"banner" => array(
        "template" => "samsfreedomfordcom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

