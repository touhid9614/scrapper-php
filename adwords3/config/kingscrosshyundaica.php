<?php

global $CronConfigs;
$CronConfigs["kingscrosshyundaica"] = array(
    "name" => " kingscrosshyundaica",
    "email" => "regan@smedia.ca",
    "password" => " kingscrosshyundaica",
    "log" => true,
    'customer_id' => '754-552-8270',
    'max_cost' => 2200,
    'bing_account_id' => 156003604,
    'cost_distribution' => array(
        'adwords' => 2200,
),
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
        "template" => "kingscrosshyundaica",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
            '#41B74B',
            '#41B74B',
),
        'button_color_hover' => array(
            '#186DB3',
            '#186DB3',
),
        'button_color_active' => array(
            '#186DB3',
            '#186DB3',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Schedule Free At-Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Kingscross Hyundai Team',
        'forward_to' => array(
            'ctso@kingscrosshyundai.ca',
            'kleung@kingscrosshyundai.ca',
            'rsantiago@kingscrosshyundai.ca',
            'rchow@kingscrosshyundai.ca',
            'asong@kingscrosshyundai.ca',
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
            'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'service' => '',
),
),
);