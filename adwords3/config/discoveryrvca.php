<?php
global $CronConfigs;
$CronConfigs["discoveryrvca"] = array( 
	"name"  => "discoveryrvca",
	"email" => "regan@smedia.ca",
	"password" => "discoveryrvca",
	//"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
	"banner" => array(
        "template" => "discoveryrvca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

