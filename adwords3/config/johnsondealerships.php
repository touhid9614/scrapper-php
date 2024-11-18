<?php

global $CronConfigs;

$CronConfigs["johnsondealerships"] = array(
    'password'  => 'johnsondealerships',
    "email"         => "regan@smedia.ca",
    'log'           => true,
    "banner"        => array(
        "template"          => "johnsondealerships",
		'fb_description'	=> 'Are you still interested in the [year] [make] [model]? Click for more info.',
        "flash_style"       => "default",
        "border_color"    => "#282828",
        "font_color"        => "#ffffff"
    )
);