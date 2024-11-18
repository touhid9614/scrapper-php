<?php

global $CronConfigs;
$CronConfigs["fortwaynetoyota"] = array(
    "name" => " fortwaynetoyota",
    "email" => "regan@smedia.ca",
    "password" => " fortwaynetoyota",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "fortwaynetoyota",
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
            '#CB2026',
            '#CB2026',
),
        'button_color_hover' => array(
            '#651417',
            '#651417',
),
        'button_color_active' => array(
            '#651417',
            '#651417',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 offer from Fort Wayne Toyota',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fort Wayne Toyota Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@fortwaynetoyota.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);