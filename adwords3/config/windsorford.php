<?php

global $CronConfigs;

$CronConfigs["windsorford"] = array(
  'password'  => 'windsorford',
    "email"         => "regan@smedia.ca",
	'fb_brand'      => '[year] [make] [model] - [body_style]',    
	'log'           => true,

    "banner"        => array(
        "template"          => "windsorford",
			"fb_description" => "Are you still interested in the [year] [make] [model]? See us today!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
			//"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
		"flash_style"       => "default",
		"border_color"    => "#282828",
        "font_color"        => "#ffffff"
    ),
);
