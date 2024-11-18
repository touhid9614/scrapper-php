<?php

global $CronConfigs;

$CronConfigs["bowmargm"] = array(
    'name'         => 'bowmargm',
    'email'        => 'regan@smedia.ca',
    'password'     => 'bowmargm',
    'log'          => true,
    'fb_brand'     => '[year] [make] [model] - [body_style]',
    'banner'       => array(
        'template'                 => 'bowmargm',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'lead'         => array(
        'live'                   => false,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#446684',
            '#446684',
        ),
        'button_color_hover'     => array(
            '#333333',
            '#333333',
        ),
        'button_color_active'    => array(
            '#333333',
            '#333333',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Bow Mar Sales Ltd',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bow Mar Sales Team',
        'forward_to'             => array(
            'bowmar@sasktel.net',
            'rolly.bowmar@sasktel.net',
            'marshal@smedia.ca',
        ),
        'respond_from'           => 'offers@mail.smedia.ca',
        'forward_from'           => 'offers@mail.smedia.ca',
        'thank_you'              => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in'                => array(
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
        ),
    ),
    'lead_to'      => array(
        'rolly.bowmar@sasktel.net',
        'bowmar@sasktel.net',
    ),
    'form_live'    => false,
    'buttons_live' => false,
);
