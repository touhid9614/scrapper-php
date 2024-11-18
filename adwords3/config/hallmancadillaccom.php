<?php
global $CronConfigs;
$CronConfigs["hallmancadillaccom"] = array( 
	"name"  => "hallmancadillaccom",
	"email" => "regan@smedia.ca",
	"password" => "hallmancadillaccom",
	"log" => true,
        "combined_feed_mode" => true,
        'max_cost' => 520,
        'cost_distribution' => array(
            'adwords' => 520,
         ),
        "customer_id" => "205-401-9397",
	
	"banner" => array(
        "template" => "hallmancadillaccom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click to learn more.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today. Click for further information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

