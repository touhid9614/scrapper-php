<?php

global $CronConfigs;
$CronConfigs["pentictonkia"] = array(
    'password' => 'pentictonkia',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "pentictonkia",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_title" => "[year] [make] [model]",
    ),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#C3002F',
            '#C3002F',
        ),
        'button_color_hover' => array(
            '#000000',
            '#000000',
        ),
        'button_color_active' => array(
            '#000000',
            '#000000',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Penticton Kia',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Penticton Kia Team',
        'forward_to' => array(
            'rklym@pentictonkia.com',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
);