<?php

global $CronConfigs;
$CronConfigs["northstargm"] = array(
    'password' => 'northstargm',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#1E4387',
            '#1E4387',
        ),
        'button_color_hover' => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 offer from North Star GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>North Star GM Team',
        'forward_to' => array(
            'northstarcranbrook1@pbssystems.com',
            'sales@northstargm.com',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
    "banner" => array(
        "template" => "northstargm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Shop North Star GM: A Tradition of Trust in Cranbrook ",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);