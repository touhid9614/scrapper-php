<?php
global $CronConfigs;
$CronConfigs["millsautocom"] = array( 
	"name"  => "millsautocom",
	"email" => "regan@smedia.ca",
	"password" => "millsautocom",
	"log" => true,
        "combined_feed_mode" => true,
	'max_cost' => 3000,
        'cost_distribution' => array(
            'adwords' => 3000,
        ),
        'customer_id' => '341-956-9295',
	"banner" => array(
            "template" => "millsautocom",
                    "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
                    "fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
            "flash_style" => "default",
            "border_color" => "#282828",
            "font_color" => "#ffffff"
    ),
);

