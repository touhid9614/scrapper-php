<?php

global $CronConfigs;
$CronConfigs["winnipegautogroup"] = array(
    'name' => 'winnipegautogroup',
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'winnipegautogroup',
    'log' => true,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 400,
    'start_date' => '16 May 2016',
    'prorated_budget' => 750.0,
    "email" => "regan@smedia.ca",
    'retargetting_delay' => 30000,
    //tracker
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        //https://app.asana.com/0/687248649257779/1200570003527786
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => true,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => false,
            'desktop' => false,
            'tablet' => false,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#730200',
            '#730200',
),
        'button_color_active' => array(
            '#383737',
            '#383737',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Win a 70’ Smart TV at Winnipeg Auto Group',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Winnipeg Auto Group',
        'forward_to' => array(
            'mkelly@winnipegautogroup.com',
            'ddurant@winnipegautogroup.com',
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
    "smart_ad_url" => "http://www.winnipegautogroup.com/all-inventory/index.htm?model=[model]&year=[year]&make=[make]",
    "post_code" => "S4R 8G3",
    "new_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    "customer_id" => "111-894-6846",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "winnipegautogroup",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]. Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info to get \$350 VISA gift card, and a product specialist will be in touch to aid in any questions.",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#000",
        "styels" => array(
            "new_display" => "quick_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "quick_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "quick_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    'cost_distribution' => array(
        'new' => 350,
        'used' => 900,
),
);