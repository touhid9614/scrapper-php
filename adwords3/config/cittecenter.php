<?php

global $CronConfigs;

$CronConfigs["cittecenter"] = array(
    'name'              => 'cittecenter',
    'email'             => 'regan@smedia.ca',
    'password'          => 'cittecenter',
    'log'               => true,
    'customer_id'       => '951-934-7100',
    'max_cost'          => 1000.0,
    'cost_distribution' => array(
        'adwords' => 1000,
    ),
    'create'            => array(
    ),
    'new_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'banner'            => array(
        'template'                   => 'cittecenter',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'styels'                     => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'bg_color'               => '#efefef',
        'text_color'             => '#404450',
        'border_color'           => '#e5e5e5',
        'button_color'           => array(
            '#1e4387',
            '#1e4387',
        ),
        'button_color_hover'     => array(
            '#1a3972',
            '#1a3972',
        ),
        'button_color_active'    => array(
            '#1a3972',
            '#1a3972',
        ),
        'button_text_color'      => '#ffffff',
        'response_email_subject' => '$250 offer from Citte Center',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Citte Center Team',
        'forward_to'             => array(
            'cittecenter@comcast.net',
            'marshal@smedia.ca',
        ),
        'respond_from'           => 'offers@mail.smedia.ca',
        'forward_from'           => 'offers@mail.smedia.ca',
        'thank_you'              => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in'                => array(
            'vdp'           => '/\\/vdp\\/[0-9].*\\//i',
            'service_regex' => '',
        ),
    ),
);