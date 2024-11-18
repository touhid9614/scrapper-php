<?php
global $CronConfigs;
$CronConfigs["newbrunswickcadillaccom"] = array( 
	"name"  => "newbrunswickcadillaccom",
	"email" => "regan@smedia.ca",
	"password" => "newbrunswickcadillaccom",
	"log" => true,
    	"combined_feed_mode" => true,
	'customer_id' => '154-225-7339',
        'max_cost' => 0.01,
        'cost_distribution' => array(
            'adwords' => 0.01,
        ),	
	"banner" => array(
        "template" => "newbrunswickcadillaccom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click to learn more.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today. Click for further information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

