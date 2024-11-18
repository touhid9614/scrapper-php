<?php

global $CronConfigs;
$CronConfigs["bigtoppowersportscom"] = array(
    "name" => " bigtoppowersportscom",
    "email" => "regan@smedia.ca",
    "password" => " bigtoppowersportscom",
    "log" => true,
    "banner" => array(
        "template" => "bigtoppowersportscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
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
            '#F4102E',
            '#F4102E',
),
        'button_color_hover' => array(
            '#FF8393',
            '#F4102E',
),
        'button_color_active' => array(
            '#7F0919',
            '#F4102E',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Big Top Powersports',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Big Top Powersports Team',
        'forward_to' => array(
            'dalewallis2@gmail.com',
            'monica@bigtoppowersports.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);