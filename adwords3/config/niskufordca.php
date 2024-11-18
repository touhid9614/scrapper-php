<?php
global $CronConfigs;
$CronConfigs["niskufordca"] = array( 
	"name"  =>" niskufordca",
	"email" => "regan@smedia.ca",
	"password" =>" niskufordca",
	"log" => true,
	'combined_feed_mode' => true,
	'max_cost' => 0.01,
        'cost_distribution' => array(
            'adwords' => 0.01,
         ),
        "customer_id" => "115-786-0345",
	"banner" => array(
        "template" => "niskufordca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

