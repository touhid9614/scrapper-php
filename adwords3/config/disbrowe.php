<?php

global $CronConfigs;
$CronConfigs["disbrowe"] = array(
    'name'               => 'disbrowe',
    'bid'                => 3.0,
    'password'           => 'disbrowe',
    'bid_modifier'       => array(
        'after' => 45,
        'bid'   => 1.5,
    ),
    'max_cost'           => 298,
    'cost_distribution'  => array(
        'used' => 298,
    ),
    'start_date'         => '09 May 2016',
    'prorated_budget'    => 550.0,
    'email'              => 'regan@smedia.ca',
    'fb_brand'           => '[year] [make] [model] - [body_style]',
    'log'                => true,
    'retargetting_delay' => 30000,
    'post_code'          => 'N5P 4E6',
    'lead'               => array(
        'live'                      => true,
        'lead_type_'                => true,
        'lead_type_new'             => true,
        'lead_type_used'            => true,
        'lead_type_service'         => true,
        'shown_cap'                 => false,
        'fillup_cap'                => false,
        'session_close'             => false,
        'inactivity'                => true,
        'exit_intent'               => true,
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
            '#0C3586',
            '#0C3586',
        ),
        'button_color_hover'        => array(
            '#02256A',
            '#02256A',
        ),
        'button_color_active'       => array(
            '#02256A',
            '#02256A',
        ),
        'button_text_color'         => '#FFFFFF',
        'forward_email_subject'     => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject'    => 'Your $200 trade in bonus from Disbrowe Chevrolet Buick GMC Cadillac',
        'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Disbrowe Chevrolet Buick GMC Cadillac ',
        'forward_to'                => array(
            'disbrowekaren@yahoo.ca',
            'disbrowesusan@gmail.com ',
        ),
        'special_to'                => array(
            '',
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
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
        ),
        'custom_div'                => '',
        'provider_name'             => 'sMedia',
        'source'                    => 'sMedia smartoffer',
    ),
    'create'             => array(
        'used_search' => true,
    ),
    'new_descs'          => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
        ),
    ),
    'used_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
        ),
    ),
    'options_descs'      => array(
        array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
        ),
    ),
    'ymmcount_descs'     => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
        ),
    ),
    'customer_id'        => '384-023-3146',
    'banner'             => array(
        'template'                 => 'disbrowe',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more information. *Open regular hours by appointment only.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information. *Open regular hours by appointment only.',
        'flash_style'              => 'default',
        'border_color'             => '#101010',
        'styels'                   => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
        'font_color'               => '#333333',
    ),
    'smart_memo'         => array(
        'live'                => false,
        'live_new'            => false,
        'live_used'           => false,
        'live_home'           => false,
        'live_service'        => false,
        'video'               => false,
        'video_url'           => '',
        'button_text'         => 'GET THE OFFER',
        'url'                 => 'https://www.disbrowe.com/ContactUsForm',
        'home_url'            => 'https://www.disbrowe.com/',
        'bg_color'            => '#EFEFEF',
        'text_color'          => '#404450',
        'border_color'        => '#E5E5E5',
        'button_text_color'   => '#FFFFFF',
        'button_color'        => array(
            '#0C3586',
            '#0C3586',
        ),
        'button_color_hover'  => array(
            '#02256A',
            '#02256A',
        ),
        'button_color_active' => array(
            '#02256A',
            '#02256A',
        ),
        'service_regex'       => '',
    ),
);