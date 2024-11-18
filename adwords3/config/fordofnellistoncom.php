<?php
global $CronConfigs;
$CronConfigs["fordofnellistoncom"] = array( 
	"name"  =>"fordofnellistoncom",
	"email" => "regan@smedia.ca",
	"password" =>"fordofnellistoncom",
	"log" => true,
	'customer_id' => '434-847-7029',
        'max_cost' => 400,
        'cost_distribution' => array(
            'adwords' => 400,
        ),
	   "banner" => array(
        "template" => "fordofnellistoncom",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);

