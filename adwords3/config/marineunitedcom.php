<?php

global $CronConfigs;
$CronConfigs["marineunitedcom"] = array(
    "name" => " marineunitedcom",
    "email" => "regan@smedia.ca",
    "password" => " marineunitedcom",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "marineunitedcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
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
            '#3E72B8',
            '#3E72B8',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#000000',
            '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Marine United',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Marine United Team',
        'forward_to' => array(
            'rory.lewis@marineunited.com',
            'rory.lewis@motounited.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);