<?php

global $CronConfigs;
$CronConfigs["fortwaynekia"] = array(
    'name'              => 'fortwaynekia',
    'email'             => 'regan@smedia.ca',
    'password'          => 'fortwaynekia',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'log'               => true,
    'fb_title'          => '[year] [make] [model] [price]',
    'banner'            => array(
        'template'                   => 'fortwaynekia',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_aia_description'         => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
        'lead_type_used'         => false,
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
            '#C3002F',
            '#C3002F',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#000000',
            '#000000',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Fort Wayne Kia',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fort Wayne Kia Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@fortwaynetoyota.com',
        ),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'lead_in'                => array(
            'vdp'           => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'max_cost'          => 1718,
    'cost_distribution' => array(
        'adwords' => 1718,
    ),
);