<?php
global $CronConfigs;
$CronConfigs["ottobotmotorscom"] = array( 
	"name"  =>" ottobotmotorscom",
	"email" => "regan@smedia.ca",
	"password" =>" ottobotmotorscom",
	"log" => true,
	'combined_feed_mode' => true,
	'customer_id' => '153-011-9309',
        'max_cost' => 600,
        'cost_distribution' => array(
            'adwords' => 600,
        ),
	"banner" => array(
        "template" => "ottobotmotorscom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

