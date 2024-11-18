<?php

global $CronConfigs;
$CronConfigs["lussiersales"] = array(
    "name" => " lussiersales",
    "email" => "regan@smedia.ca",
    "password" => " lussiersales",
    "log" => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#E52424',
            '#E52424',
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
        'response_email_subject' => '$200 OFF coupon from Lussier Sales',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Lussier Sales Team',
        'forward_to' => array(
            'meaghanlussier@hotmail.com',
            'info@lussiersales.com',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
    "banner" => array(
        "template" => "lussiersales",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);