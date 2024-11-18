<?php

global $CronConfigs;
$CronConfigs["blackbridgeharley"] = array(
    "name" => " blackbridgeharley",
    "email" => "regan@smedia.ca",
    "password" => " blackbridgeharley",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bing_account_id' => 156002851,
    "log" => true,
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
    "banner" => array(
        "template" => "blackbridgeharley",
        "fb_description" => "Is this [year] [make] [model] your next Harley?",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        'snapchat_image_index' => 0,
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
            '#D6701E',
            '#D6701E',
),
        'button_color_hover' => array(
            '#FF9C4C',
            '#FF9C4C',
),
        'button_color_active' => array(
            '#B56728',
            '#B56728',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 gift card from Black Bridge Harley',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Black Bridge Harley Team',
        'forward_to' => array(
            'jonathan@blackbridgeharley.com',
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