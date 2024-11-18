<?php

global $CronConfigs;
$CronConfigs["whitebearlincoln"] = array(
    'password' => 'whitebearlincoln',
    "email" => "regan@smedia.ca",
    'log' => true,
    'bing_account_id' => 156003276,
    "bing_create" => array(
        "used_search" => true,
),
    'max_cost' => 1240,
    'cost_distribution' => array(
        'adwords' => 1240,
    ),
    //========== smart offer ============
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#000000",
            "#000000",
        ),
        'button_color_hover' => array(
            "#6a0101",
            "#6a0101",
        ),
        'button_color_active' => array(
            "#1a3972",
            "#1a3972",
        ),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 offer from White Bear Lincoln",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>White Bear Lincoln Team",
        'forward_to' => array(
            "thomas.taube@wblincoln.com",
            "marshal@smedia.ca",
        ),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
    "create" => array(
        "used_search" => yes,
        "used_display" => no,
        "used_retargeting" => yes,
        "used_marketbuyers" => no,
        "used_combined" => yes,
        "used_placement" => yes,
    ),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
        ),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "customer_id" => "244-552-9144",
    "banner" => array(
        "template" => "whitebearlincoln",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
        ),
        "font_color" => "#ffffff",
    ),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17614',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);