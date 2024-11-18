<?php

global $CronConfigs;
$CronConfigs["alexandriacampingcentre"] = array(
    'password' => 'alexandriacampingcentre',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#008CD5',
            '#008CD5',
),
        'button_color_hover' => array(
            '#009549',
            '#009549',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Your  50% off an RV Cover Coupon',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Alexandria Camping Centre Team',
        'forward_to' => array(
            'dtan@alexandriacc.ca',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' => array(
            'vdp' => '/\\/default.asp\\?page=x(?:New|PreOwned)InventoryDetail/i',
            'service_regex' => '',
),
),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'alexandriacampingcentre',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out the [year] [make] [model] today!',
        'fb_dynamiclead_description' => 'Still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to help.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'name' => 'alexandriacampingcentre',
    'max_cost' => 1100,
    'cost_distribution' => array(
        'adwords' => 1100,
),
);