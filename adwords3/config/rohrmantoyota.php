<?php

global $CronConfigs;
$CronConfigs["rohrmantoyota"] = array(
    "name" => " rohrmantoyota",
    "email" => "regan@smedia.ca",
    "password" => " rohrmantoyota",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "banner" => array(
        "template" => "rohrmantoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#D20000',
            '#D20000',
),
        'button_color_hover' => array(
            '#333333',
            '#333333',
),
        'button_color_active' => array(
            '#333333',
            '#333333',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Bob Rohrman Toyota',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bob Rohrman Toyota Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@rohrmantoyota.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);