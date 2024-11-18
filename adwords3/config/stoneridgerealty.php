<?php

global $CronConfigs;
$CronConfigs["stoneridgerealty"] = array(
    "name" => " stoneridgerealty",
    "email" => "regan@smedia.ca",
    "password" => " stoneridgerealty",
    "log" => true,
    "lead" => array(
        'live' => false,
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
            '#5D3547',
            '#5D3547',
        ),
        'button_color_active' => array(
            '#5D3547',
            '#5D3547',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get a Trip to Mexico.',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Stone Ridge Realty Team',
        'forward_to' => array(
            'k.hinton@sasktel.net',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "dealership",
        "fb_description" => "Are you still interested in the [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out the [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
        ),
    ),
);