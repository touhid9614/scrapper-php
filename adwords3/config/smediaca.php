<?php

global $CronConfigs;
$CronConfigs["smediaca"] = array(
    "name" => " smediaca",
    "email" => "regan@smedia.ca",
    "password" => " smediaca",
    "no_adv" => true,
    'lead' => array(
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
            'vdp' => '',
            'service' => '',
),
),
);