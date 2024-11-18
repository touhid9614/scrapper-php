<?php

global $CronConfigs;
$CronConfigs["destinationcyclescom"] = array(
    "name" => " destinationcyclescom",
    "email" => "regan@smedia.ca",
    "password" => " destinationcyclescom",
    "log" => true,
    "banner" => array(
        'template' => 'destinationcyclescom',
        'fb_marketplace_description' => '[description]',
		'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
		'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
	    'fb_marketplace_title' => '[year] [make] [model] [price]',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),      
),
);