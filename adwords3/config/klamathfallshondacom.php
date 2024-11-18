<?php
global $CronConfigs;
$CronConfigs["klamathfallshondacom"] = array( 
	"name"  => "klamathfallshondacom",
	"email" => "regan@smedia.ca",
	"password" => "klamathfallshondacom",
	"log" => true,
        'max_cost' => 500,
        'cost_distribution' => array(
            'adwords' => 500,
),
        "customer_id"   => "638-068-0505",
    "combined_feed_mode" => true,
	"banner" => array(
        "template" => "klamathfallshondacom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

