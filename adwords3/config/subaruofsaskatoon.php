<?php

global $CronConfigs;
$CronConfigs["subaruofsaskatoon"] = array(
    "name" => " subaruofsaskatoon",
    "email" => "regan@smedia.ca",
    "password" => " subaruofsaskatoon",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "subaruofsaskatoon",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
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
            '#0097D0',
            '#0097D0',
        ),
        'button_color_hover' => array(
            '#242424',
            '#242424',
        ),
        'button_color_active' => array(
            '#242424',
            '#242424',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Subaru of Saskatoon',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Subaru of Saskatoon Team',
        'forward_to' => array(
            'mark@websitedepartment.ca',
            'saskatoon.subaru@gmail.com',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
);