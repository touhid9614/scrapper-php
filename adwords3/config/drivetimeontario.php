<?php

global $CronConfigs;
$CronConfigs["drivetimeontario"] = array(
    'name' => 'drivetimeontario',
    'email' => 'regan@smedia.ca',
    'password' => 'drivetimeontario',
    'log' => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '930-450-7600',
    'banner' => array(
        'template' => 'drivetimeontario',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => false,
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
            '#00C47D',
            '#00C47D',
),
        'button_color_hover' => array(
            '#FDB006',
            '#FDB006',
),
        'button_color_active' => array(
            '#FDB006',
            '#FDB006',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim $250 off with a purchase at Drive Time Ontario',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Drive Time Ontario Team',
        'forward_to' => array(
            'drivetimeapprovals@gmail.com',
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
            'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
            'service_regex' => '',
),
),
    'smart_memo' => array(
        'live' => true,
        'live_new' => false,
        'live_used' => false,
        'live_home' => true,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => true,
        'video_url' => '',
        'button_text' => 'GET APPRAISAL',
        'url' => 'https://drivetimeontario.ca/',
        'home_url' => 'https://drivetimeontario.ca/',
        'service_regex' => '',
        'bg_color' => '#00A167',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#00A167',
            '#00A167',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#00A167',
            '#00A167',
),
),
);