<?php

global $CronConfigs;
$CronConfigs["toyotabountiful"] = array(
    'password' => 'toyotabountiful',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'bing_account_id' => 156002889,
    'max_cost' => 2300,
    'cost_distribution' => array(
        'adwords' => 2300,
),
    'create' => array(
        "new_search" => yes,
        "used_search" => yes,
),
    'new_descs' => array(
        0 => null,
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '345-074-3462',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'toyotabountiful',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your information, and a product specialist will be in touch to aid in any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'fb_config' => array(
        'monthly_budget' => 200,
        'account_id' => '1280776411960319',
        'page_id' => '109838575761282',
        'pixel_id' => '1718339738476440',
        'dataset' => '1962606647306346',
        'form_id' => '',
        'action_types' => array(
            0 => 'click',
),
        'plain' => false,
        'include_stock' => false,
        'polk_data' => true,
        'targeting' => array(
            'desktop' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        0 => array(
                            'key' => 3887,
                            'name' => 'Utah',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        0 => 'home',
),
),
                'publisher_platforms' => array(
                    0 => 'facebook',
),
                'facebook_positions' => array(
                    0 => 'feed',
),
                'device_platforms' => array(
                    0 => 'desktop',
),
),
            'mobile' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        0 => array(
                            'key' => 3887,
                            'name' => 'Utah',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        0 => 'home',
),
),
                'publisher_platforms' => array(
                    0 => 'facebook',
),
                'facebook_positions' => array(
                    0 => 'feed',
),
                'device_platforms' => array(
                    0 => 'mobile',
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17611',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'name' => 'toyotabountiful',
    'lead' => array(
        'new' => array(
            'live' => false,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => false,
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
                '#EB0A1E',
                '#EB0A1E',
),
            'button_color_hover' => array(
                '#BA0818',
                '#BA0818',
),
            'button_color_active' => array(
                '#EB0A1E',
                '#EB0A1E',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => 'Reserve Your New Vehicle at Performance Toyota Bountiful',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\\"[image]\\"/><p><br><br>Performance Toyota Bountiful Team',
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
                'vdp' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
),
);