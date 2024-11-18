<?php

global $CronConfigs;
$CronConfigs["jeffsmith"] = array(
    'name' => 'Dave Hitchcock',
    //'budget'    => 2.0,
    'bid' => 3.0,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'password' => 'jeffsmith',
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 817,
    'cost_distribution' => array(
        'adwords' => 240,
        'youtube' => 577,
),
    'log' => true,
    "email" => "regan@smedia.ca",
    'post_code' => 'N8M 2C8',
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
        "used_combined" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
),
    //'fb_title'     => '[year] [make] [model] [trim] [price]',
    "new_descs" => array(
        array(
            "title2" => "Huge Selection, Huge Savings",
            "desc" => "Call us today about the [year] [make] [model]. Book a Test Drive.",
),
        array(
            "title2" => "Book a Test Drive",
            "desc" => "Test Drive the [year] [make] [model] today. View All Our Inventory Online 24/7.",
),
        array(
            "title2" => "Book a Test Drive",
            "desc" => "Test Drive the [year] [make] [model] today. Informative online car shopping.",
),
),
    "used_descs" => array(
        array(
            "title2" => "Huge Selection, Huge Savings",
            "desc" => "Call us today about the [year] [make] [model]. Book a Test Drive.",
),
        array(
            "title2" => "Book a Test Drive",
            "desc" => "Test Drive the [year] [make] [model] today. View All Our Inventory Online 24/7.",
),
        array(
            "title2" => "Book a Test Drive",
            "desc" => "Test Drive the [year] [make] [model] today. Informative online car shopping.",
),
),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    'bing_account_id' => 156003020,
    "customer_id" => "219-567-0339",
    "email" => "regan@smedia.ca",
    "banner" => array(
        "fb_banner_title" => '[year] [make] [model] [trim]',
        "template" => "jeffsmith",
        "flash_style" => "default",
        'fb_description_new' => 'Save time! Click here to view full spec’s, pictures and video of this new [year] [make] [model]. Drive this for [biweekly] bi-weekly.',
        'fb_description_used' => 'Save time! Click here to view full spec’s, pictures and video of this used [year] [make] [model].',
        //'fb_2019trax_description' => 'Check out the amazing deals on this very popular, functional and stylish SUV. 0% Financing for up to 72 months or a $5100 cash credit on the 2019 Trax! We have the best Trax selection in Essex County, check them out here www.countychevroletessex.com! PLUS GET AN ADDITONAL $500 DISCOUNT ONLY AT COUNTY CHEVROLET.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]?  Please click below, fill in your info and a product specialist will contact you to answer any of your questions.',
        "hst" => yes,
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_search" => "custom_banner",
            "used_search" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
            "new_placement" => "custom_banner",
            "used_placement" => "custom_banner",
),
        "font_color" => "FFFFFF",
),
);