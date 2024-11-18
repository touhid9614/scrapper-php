<?php

global $CronConfigs;
$CronConfigs["westshoremarine"] = array(
    "name" => " westshoremarine",
    "email" => "regan@smedia.ca",
    "password" => " westshoremarine",
    "log" => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "westshoremarine",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
        'text_color' => '#FFFFFF',
        'border_color' => '#FFFFFF',
        'button_color' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_hover' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_active' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '',
        'response_email' => '',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'webleads@westshoremarine.ca',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);