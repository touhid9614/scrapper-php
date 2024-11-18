<?php

global $CronConfigs;

$CronConfigs["bradleygm"] = array(
    'name'         => 'bradleygm',
    'email'        => 'regan@smedia.ca',
    'password'     => 'bradleygm',
    'fb_brand'     => '[year] [make] [model] - [body_style]',
    'log'          => true,
    'banner'       => array(
        'template'                 => 'bradleygm',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => 'ffffff',
    ),
    'lead'         => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'shown_cap'              => false,
        'fillup_cap'             => false,
        'session_close'          => false,
        'device_type'            => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#67696B',
            '#67696B',
        ),
        'button_color_hover'     => array(
            '#3F7D98',
            '#3F7D98',
        ),
        'button_color_active'    => array(
            '#3F7D98',
            '#3F7D98',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from L.H. Bradley & Son Ltd',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bradley & Son Team',
        'forward_to'             => array(
            'robbradley@sasktel.net',
            'jeff.mcgonigal@sasktel.net',
            'murraygray@sasktel.net',
            'marshal@smedia.ca',
        ),
        'special_to'             => array(),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'lead_in'                => array(
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}/i',
            'service_regex' => '',
        ),
    ),
    'lead_to'      => array(
        'robbradley@sasktel.net',
        'jeff.mcgonigal@sasktel.net',
        'murraygray@sasktel.net',
    ),
    'form_live'    => false,
    'buttons_live' => false,
);
