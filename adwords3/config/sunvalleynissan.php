<?php

global $CronConfigs;
$CronConfigs["sunvalleynissan"] = array(
    "name" => " sunvalleynissan",
    "email" => "regan@smedia.ca",
    "password" => " sunvalleynissan",
    "log" => true,
    'combined_feed_mode' => true,
    "customer_id" => "474-376-9541",
    'max_cost' => 200,
    'cost_distribution' => array(
        'adwords' => 200,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "banner" => array(
        "template" => "sunvalleynissan",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info. Stock #: [stock_number].',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information. Stock #: [stock_number].',
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
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
            '#C51633',
            '#C51633',
),
        'button_color_hover' => array(
            '#232323',
            '#232323',
),
        'button_color_active' => array(
            '#232323',
            '#232323',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim $1000 Cash Back OAC at Sun Valley Nissan',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sun Valley Nissan Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'jamie@sunvalleynissan.com',
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
            'vdp' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
            'service' => '',
),
),
);