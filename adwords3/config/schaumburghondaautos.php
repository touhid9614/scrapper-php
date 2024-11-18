<?php

global $CronConfigs;
$CronConfigs["schaumburghondaautos"] = array(
    "name" => " schaumburghondaautos",
    "email" => "regan@smedia.ca",
    "password" => " schaumburghondaautos",
    "no_adv" => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "fb_title" => "[year] [make] [model] [trim] [price]",
    'log' => true,
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "schaumburghondaautos",
        "fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Click for more info!",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_lookalike_description" => "Check out this [year] [make] [model] [trim]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0D65BF',
            '#0D65BF',
),
        'button_color_hover' => array(
            '#0B55A6',
            '#0B55A6',
),
        'button_color_active' => array(
            '#0B55A6',
            '#0B55A6',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Schaumburg Honda Automobiles',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Schaumburg Honda Autos Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@schaumburghonda.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    'max_cost' => 4443,
    'cost_distribution' => array(
        'new' => 2222,
        'used' => 2221,
),
);