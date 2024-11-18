<?php

global $CronConfigs;
$CronConfigs["fasttoysforboyscom"] = array(
    "name" => " fasttoysforboyscom",
    "email" => "regan@smedia.ca",
    "password" => " fasttoysforboyscom",
    "log" => true,
    "banner" => array(
        "template" => "fasttoysforboyscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
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
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#F11921',
            '#F11921',
),
        'button_color_hover' => array(
            '#FF696F',
            '#F11921',
),
        'button_color_active' => array(
            '#971116',
            '#F11921',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 coupon from Fast Toys For Boys',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fast Toys For Boys Team',
        'forward_to' => array(
            'terry@fasttoysforboys.com',
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