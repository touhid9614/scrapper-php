<?php

global $CronConfigs;
$CronConfigs["rohrmankia"] = array(
    "name" => " rohrmankia",
    "email" => "regan@smedia.ca",
    "password" => " rohrmankia",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "banner" => array(
        "template" => "rohrmankia",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
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
            '#B32434',
            '#B32434',
),
        'button_color_hover' => array(
            '#3B3838',
            '#3B3838',
),
        'button_color_active' => array(
            '#3B3838',
            '#3B3838',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Bob Rohrman Kia',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bob Rohrman Kia Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@rohrmankia.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);