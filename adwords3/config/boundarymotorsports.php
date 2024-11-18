<?php

global $CronConfigs;

$CronConfigs["boundarymotorsports"] = array(
  'password'  => 'bigwestdodge',
    "email"         => "regan@smedia.ca",
    'log'           => true,
    "fb_title" => "[year] [make] [trim] [price]",
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    "customer_id"   => "260-959-9662",
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords'  => 0,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
    ),
   
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
    "banner"        => array(
        "template"          => "boundarymotorsports",
		'fb_description'	=> 'Are you still interested in the [year] [make] [trim]? Up to 0% finance on select models! Shop now.',
		"fb_lookalike_description"	=> "Check out this [year] [make] [trim] today! Up to 0% finance on select models. Shop now!",
			"flash_style"       => "default",
			"border_color"    => "#282828",
            "styels" => array(
                "new_display" => "custom_banner",
                "used_display" => "custom_banner",
                "new_retargeting" => "custom_banner",
                "used_retargeting" => "custom_banner",
                "new_marketbuyers" => "custom_banner",
                "used_marketbuyers" => "custom_banner"
        ),
        "font_color"        => "#ffffff"
        ),
       
    );


