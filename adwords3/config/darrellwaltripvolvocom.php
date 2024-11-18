<?php
global $CronConfigs;
$CronConfigs["darrellwaltripvolvocom"] = array( 
	"name"  => "darrellwaltripvolvocom",
	"email" => "regan@smedia.ca",
	"password" => "darrellwaltripvolvocom",
	"log" => true,
        'combined_feed_mode' => true,
        'max_cost' => 1250,
        'cost_distribution' => array(
            'adwords' => 1250,
         ),
        "customer_id" => "601-692-4484",
	
	"banner" => array(
        "template" => "darrellwaltripvolvocom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

