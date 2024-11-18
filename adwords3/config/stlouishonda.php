<?php
global $CronConfigs;
 $CronConfigs["stlouishonda"] = array( 
    'password'  => 'stlouishonda',
    "email"         => "regan@smedia.ca",
    'log'           => true,
     'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "stlouishonda",
		'fb_description'	=> "Are you still interested in the [year] [make] [model]? Click below for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
            "flash_style" => "default",
            "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);