<?php
global $CronConfigs;
$CronConfigs["overdrive_usacom"] = array( 
	"name"  =>" overdrive_usacom",
	"email" => "regan@smedia.ca",
	"password" =>" overdrive_usacom",
	'combined_feed_mode' => true,
	"log" => true,
        'customer_id' => '893-150-7184',
        'max_cost' => 1500,
        'cost_distribution' => array(
        'adwords' => 1500,
        ),
	'bing_account_id' => 156003878,
        "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
            ),
        ),
        "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
            ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
            ),
        ),
        "banner" => array(
        "template" => "overdrive_usacom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
        ),
        "border_color" => "#282828",
        "font_color" => "#ffffff"
        ),
);

