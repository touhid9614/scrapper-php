<?php

global $CronConfigs;

$CronConfigs["happyrv"] = array(
    'password'      => 'happyrv',
    "email"         => "regan@smedia.ca",
    'log'           => true,
    "banner"        => array(
        "template"          => "happyrv",
		'fb_description'	=> 'Are you still interested in the [year] [make] [model]? Click for more information.',
		"flash_style"       => "default",
		"border_color"    => "#282828",
        "font_color"        => "#ffffff"
        )
);