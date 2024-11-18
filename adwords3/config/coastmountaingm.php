<?php

global $CronConfigs;

$CronConfigs["coastmountaingm"] = array(
    'password' => 'coastmountaingm',
    'email'    => 'regan@smedia.ca',
    'log'      => true,
    'lead'     => array(
        'live'                   => false,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#4E8AA4',
            '#4E8AA4',
        ),
        'button_color_hover'     => array(
            '#3E6D81',
            '#3E6D81',
        ),
        'button_color_active'    => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $200 OFF from Coast Mountain GM',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Coast Mountain GM Team',
        'forward_to'             => array(
            'cameron@coastmountaingm.com',
            'sinead@coastmountaingm.com',
            'marshal@smedia.ca',
        ),
        'respond_from'           => 'offers@mail.smedia.ca',
        'forward_from'           => 'offers@mail.smedia.ca',
        'thank_you'              => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'lead_in'                => array(
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
        ),
    ),
    'banner'   => array(
        'template'                 => 'coastmountaingm',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'name'     => 'coastmountaingm',
);
