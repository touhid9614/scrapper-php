<?php

global $CronConfigs;
$CronConfigs["mbregina"] = array(
    'name' => 'Mbregina',
    //'budget'    => 2.0,
    'password' => 'mbregina',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    // 'no_adv' => true,
    'combined_feed_mode' => true,
    'max_cost' => 3100.0,
    'smart_banner' => array(
        'live' => true,
        'title' => 'Would you like to continue shopping for',
),
    'cost_distribution' => array(
        'adwords' => 3100,
        'youtube' => 0,
),
    'password' => 'mbregina',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'bing_account_id' => 150375661,
    "email" => "marshal@smedia.ca",
    //tracker
   /* "trackers" => array(
        "new_search" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_search" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_display" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_display" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_retargeting" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_retargeting" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_combined" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_combined" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
),*/
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
),
    "host_url" => "http://mbregina.autotrader.ca",
    //must start with http or https and end without /
    "display_url" => "http://mbregina.autotrader.ca",
    //Max lenght 35 char
    "new_descs" => array(
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
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
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
    "customer_id" => "303-035-6432",
    "email" => "marshal@smedia.ca",
    "banner" => array(
        "template" => "mbregina",
        "fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Contact us today to schedule a virtual test drive.",
        /*"fb_description_2018_mercedes-benz_c-class" => "Are you still interested in the [year] [make] [model]? Drive this car home for $650 tax paid per month with $1300 due on delivery. Click for more info.",
          "fb_description_2018_mercedes-benz_gle" => "Are you still interested in the [year] [make] [model]? Get up to $8000 in year-end savings. Click for more info.",*/
        //"fb_lookalike_description" => "Test drive the [year] [make] [model] [trim] today.",
		"fb_lookalike_description" => "Checkout this [year] [make] [model] [trim]. Contact us today to schedule a virtual test drive.",
        //"fb_marketplace_description" => "[description]",
        "fb_style" => 'fb_new_rightsidebar',
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
        'snapchat_image_index' => 500,
),
    "phone_domelement" => 'document.getElementsByClassName("tel phone1")[0].getElementsByClassName("value")[0]',
    "phone_regex" => "/\\([0-9]{3}\\)\\s[0-9]{3}\\-[0-9]{4}/",
);