<?php

global $CronConfigs;
$CronConfigs["mertinhyundaicom"] = array(
    "name" => " mertinhyundaicom",
    "email" => "regan@smedia.ca",
    "password" => " mertinhyundaicom",
    "log" => true,
    "customer_id"   => "479-192-3603",
    'combined_feed_mode' => true,
    'max_cost' => 1100,
    'cost_distribution' => array(
        'new' => 1100,
        'used' => 0,
),

	"banner" => array(
        "template" => "mertinhyundaicom",
		"fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Click for more information.",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] [trim] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",		
    ),
);