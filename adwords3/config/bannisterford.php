<?php

global $CronConfigs;
$CronConfigs["bannisterford"] = array(
    "name" => " bannisterford",
    "email" => "regan@smedia.ca",
    "password" => "bannisterford",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    'max_cost' => 900,
    'bing_account_id' => 156002882,
    'cost_distribution' => array(
        'new' => 675,
        'used' => 225,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '310-828-5484',
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "bannisterford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        /*"fb_marketplace_description" => "[description]",
          "fb_marketplace_title" => "[year] [make] [model] [trim]",
          "old_price" => "msrp",*/
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
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
            '#0178BE',
            '#0178BE',
),
        'button_color_hover' => array(
            '#1D3C63',
            '#1D3C63',
),
        'button_color_active' => array(
            '#1D3C63',
            '#1D3C63',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 offer from Bannister Ford',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bannister Ford Team',
        'forward_to' => array(
            'mlongphee@bannisterford.com',
            'wayne@bannisterford.com',
            'smyatt@bannister.com',
            'tamissy13@gmail.com',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
),
);