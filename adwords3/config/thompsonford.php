<?php

global $CronConfigs;
$CronConfigs["thompsonford"] = array(
    "name" => " thompsonford",
    "email" => "regan@smedia.ca",
    "password" => " thompsonford",
    "log" => true,
    "banner" => array(
        "template" => "thompsonford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"flash_style" => "default",
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
            '#318DC5',
            '#318DC5',
),
        'button_color_hover' => array(
            '#194560',
            '#194560',
),
        'button_color_active' => array(
            '#194560',
            '#194560',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 offer from Thompson Ford Sales',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Thompson Ford Sales Team',
        'forward_to' => array(
            'buddy@thompsonford.ca',
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