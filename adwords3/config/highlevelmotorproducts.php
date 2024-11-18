<?php

global $CronConfigs;

$CronConfigs["highlevelmotorproducts"] = array(
    'password' => 'highlevelmotorproducts',
    "email" => "regan@smedia.ca",
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    "customer_id" => "105-836-4313",
    'max_cost' => 1200,
    'cost_distribution' => array(
        'adwords' => 600,
        'youtube' => 100,
    ),
    'log' => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array("#3e5c77", "#3e5c77"),
        'button_color_hover' => array("#2d4255", "#2d4255"),
        'button_color_active' => array("#1a3972", "#1a3972"),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "Claim your $1000 Loyalty Upgrade Bonus!",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>High Level Motor Products Team",
        'forward_to' => array("chris@highlevelmotorproducts.com", "marshal@smedia.ca"),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes
    ),
    "new_descs" => array(
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
    "banner" => array(
        "template" => "highlevelmotorproducts",
        "fb_description_new" => "Are you still interested in the [year] [make] [model]? MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. Amvic Licensed Dealership. Click for more info.",
        "fb_description_used" => "Are you still interested in the [year] [make] [model]? Sale price is [price]. Stock: [stock_number]. Amvic Licensed Dealership. Click for more info.",
        "fb_lookalike_description_new" => "Now offering Virtual Vehicle Consultations. Get more info on the [year] [make] [model] today! MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. Amvic Licensed Dealership.",
        "fb_lookalike_description_used" => "Now offering Virtual Vehicle Consultations. Get more info on the the [year] [make] [model] today! Sale price is [price]. Stock: [stock_number]. Amvic Licensed Dealership.",
//        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info or call us at 833-876-1862 today to take it for a test drive.",
//        "fb_lookalike_description" => "Test drive the [year] [make] [model] today.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_combined" => "dynamic_banner",
            "used_combined" => "dynamic_banner",
        ),
        "font_color" => "#ffffff",
    )
);
