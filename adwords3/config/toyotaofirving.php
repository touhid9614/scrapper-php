<?php

global $CronConfigs;
$CronConfigs["toyotaofirving"] = array(
    "name" => " toyotaofirving",
    "email" => "regan@smedia.ca",
    "password" => " toyotaofirving",
    "log" => true,
    'combined_feed_mode' => true,
	
	"banner" => array(
        "template" => "toyotaofirving",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
	
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17945',
        'promotion_text' => 'Call Us Today 469.919.5800',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#D2232A',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#D2232A',
        'coupon_validity' => '30',
),
);