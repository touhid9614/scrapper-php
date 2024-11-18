<?php

global $CronConfigs;
$CronConfigs["energydodge"] = array(
    'name'               => 'energydodge',
    'email'              => 'regan@smedia.ca',
    'password'           => 'energydodge',
    'customer_id'        => '361-783-4542',
    'log'                => true,
    'combined_feed_mode' => true,
    'banner'             => array(
        'template'                 => 'energydodge',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more information.',

        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => 'ffffff',
    ),
    'lead'               => array(
        'live'                   => false,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#D7232A',
            '#D7232A',
        ),
        'button_color_hover'     => array(
            '#8E161B',
            '#8E161B',
        ),
        'button_color_active'    => array(
            '#8E161B',
            '#8E161B',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Energy Dodge Chrysler Jeep Ram',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Energy Dodge Chrysler Jeep Ram Team',
        'forward_to'             => array(
            'jason@energydodge.com',
            'sales@energydodge.com',
            'marshal@smedia.ca',
        ),
        'respond_from'           => 'offers@mail.smedia.ca',
        'forward_from'           => 'offers@mail.smedia.ca',
        'thank_you'              => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in'                => array(
            'vdp'           => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'lead_to'            => array(
        'jason@energydodge.com',
        'sales@energydodge.com',
    ),
    'form_live'          => false,
    'buttons_live'       => false,
    'max_cost'           => 255,
    'cost_distribution'  => array(
        'new'     => 0,
        'used'    => 0,
        'youtube' => 255,
    ),
);
