<?php

global $CronConfigs;
$CronConfigs["candhautosalescom"] = array(
    "name" => "candhautosalescom",
    "email" => "regan@smedia.ca",
    "password" => "candhautosalescom",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "candhautosalescom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead' => array(
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'inactivity' => true,
            'exit_intent' => true,
            'session_depth' => false,
            'campaign_cap_google' => false,
            'campaign_cap_fb' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#0056B3',
                '#0056B3',
),
            'button_color_hover' => array(
                '#1C244B',
                '#1C244B',
),
            'button_color_active' => array(
                '#007BFF',
                '#007BFF',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => 'Get $700 towards your down payment or trade at C&H Auto Sales',
            'response_email' => '"Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>C&H Auto Sales Team",',
            'forward_to' => array(
                'aretha@candhautosales.com',
                'morris@morrisrivers.com',
),
            'special_to' => array(
                'chautosales@promaxonline.net',
                'aretha@candhautosales.com',
                'morris@morrisrivers.com',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'shown_cap_count' => 1,
            'fillup_cap_time_days' => 7,
            'session_close_cap' => 3,
            'inactivity_timeout' => 600000,
            'exit_intent_timeout' => 10000,
            'session_depth_page' => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days' => 7,
            'campaign_fb_cap_count' => 3,
            'campaign_fb_cap_days' => 7,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/VehicleDetails\\//i',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
),
    'smart_memo' => array(
        'live' => true,
        'live_new' => false,
        'live_used' => false,
        'live_home' => true,
        'live_service' => false,
        'video' => false,
        'video_url' => '',
        'button_text' => 'Get Paid',
        'url' => 'https://www.candhautosales.com/contact-us',
        'home_url' => 'https://www.candhautosales.com/',
        'service_regex' => '',
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
),
);