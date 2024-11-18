<?php
global $CronConfigs;
$CronConfigs["motorcoconz"] = array( 
	"name"  =>" motorcoconz",
	"email" => "regan@smedia.ca",
	"password" =>" motorcoconz",
	"log" => true,
	'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "motorcoconz",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Finance from [finance_term] per week - no deposit financing available. Call us today!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Finance from [finance_term] per week - no deposit financing available. Call us today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

