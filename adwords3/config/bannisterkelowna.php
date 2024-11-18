<?php

global $CronConfigs;

$CronConfigs["bannisterkelowna"] = array(
    'password' => 'bannisterkelowna',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '252-687-9577',
    'max_cost' => 750,
    'cost_distribution' =>
    array(
        'adwords' => 750,
    ),
    'create' =>
    array(
    ),
    'new_descs' =>
    array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs' =>
    array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'lead' =>
    array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#737373',
        'button_color' =>
        array(
            '#737373',
            '#737373',
        ),
        'button_color_hover' =>
        array(
            '#333333',
            '#333333',
        ),
        'button_color_active' =>
        array(
            '#1A3972',
            '#1A3972',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 OFF from Bannister Kelowna',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to 	claim.</p><br><img src="[image]"/><p><br><br>Bannister Kelowna Team',
        'forward_to' =>
        array(
            'kevanwinship@bannisterkelowna.com',
            'marshal@smedia.ca',
            'brianw@bannisterkelowna.com',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' =>
        array(
            'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'banner' =>
    array(
        'template' => 'bannisterkelowna',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' =>
        array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'font_color' => '#ffffff',
    ),
    'name' => 'bannisterkelowna',
);
