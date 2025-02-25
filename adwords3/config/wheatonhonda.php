<?php

global $CronConfigs;
$CronConfigs["wheatonhonda"] = array(
    'password'           => 'wheatonhonda',
    'email'              => 'regan@smedia.ca',
    'fb_brand'           => '[year] [make] [model] - [body_style]',
    'log'                => true,
    'combined_feed_mode' => true,
    'customer_id'        => '586-868-6842',
    'max_cost'           => 3250,
    'cost_distribution'  => array(
        'adwords' => 3062,
        'youtube' => 188,
    ),
    'banner'             => array(
        'template'                 => 'wheatonhonda',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'lead'               => array(
        'live'                      => false,
        'lead_type_'                => false,
        'lead_type_new'             => false,
        'lead_type_used'            => false,
        'lead_type_service'         => false,
        'shown_cap'                 => false,
        'fillup_cap'                => false,
        'session_close'             => false,
        'inactivity'                => false,
        'exit_intent'               => false,
        'session_depth'             => false,
        'campaign_cap_google'       => false,
        'campaign_cap_fb'           => false,
        'device_type'               => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'sent_client_email'         => true,
        'offer_minimum_price'       => 0,
        'offer_maximum_price'       => 10000000,
        'bg_color'                  => '#EFEFEF',
        'text_color'                => '#404450',
        'border_color'              => '#E5E5E5',
        'button_color'              => array(
            '#EB242E',
            '#EB242E',
        ),
        'button_color_hover'        => array(
            '#DB212A',
            '#DB212A',
        ),
        'button_color_active'       => array(
            '#FFFFFF',
            '#DB212A',
        ),
        'button_text_color'         => '#FFFFFF',
        'forward_email_subject'     => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject'    => '$200 off coupon from Wheaton Honda',
        'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Wheaton Honda Team',
        'forward_to'                => array(
            'leads@wheatonhonda.ca',
            'marshal@smedia.ca',
        ),
        'special_to'                => array(
            'Array',
        ),
        'special_email'             => '',
        'display_after'             => 30000,
        'retarget_after'            => 5000,
        'fb_retarget_after'         => 5000,
        'adword_retarget_after'     => 5000,
        'visit_count'               => 0,
        'shown_cap_count'           => 1,
        'fillup_cap_time_days'      => 7,
        'session_close_cap'         => 3,
        'inactivity_timeout'        => 600000,
        'exit_intent_timeout'       => 10000,
        'session_depth_page'        => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days'  => 7,
        'campaign_fb_cap_count'     => 3,
        'campaign_fb_cap_days'      => 7,
        'video_smart_offer'         => false,
        'video_smart_offer_form'    => false,
        'video_url'                 => '',
        'video_title'               => '',
        'video_description'         => '',
        'lead_in'                   => array(
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
        ),
        'custom_div'                => '',
        'provider_name'             => 'sMedia',
        'source'                    => 'sMedia smartoffer',
    ),
    'adf_to'             => array(
        'leads@wheatonhonda.ca',
    ),
    'name'               => 'wheatonhonda',
);