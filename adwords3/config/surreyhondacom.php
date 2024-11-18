<?php

global $CronConfigs;
$CronConfigs["surreyhondacom"] = array(
    "name" => " surreyhondacom",
    "email" => "regan@smedia.ca",
    "password" => " surreyhondacom",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "surreyhondacom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
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
            '#C3002F',
            '#C3002F',
),
        'button_color_hover' => array(
            '#77001D',
            '#77001D',
),
        'button_color_active' => array(
            '#77001D',
            '#77001D',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Request A Video Walk-Around of Your Vehicle of Interest',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\\"[image]\\"/><p><br><br>Surrey Honda Team',
        'forward_to' => array(
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
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service' => '',
),
),
);