<?php

global $CronConfigs;
$CronConfigs["whitewatermotors"] = array(
    'name' => 'whitewatermotors',
    'email' => 'regan@smedia.ca',
    'password' => 'whitewatermotors',
    'log' => true,
    "combined_feed_mode" => true,
    'max_cost' => 475,
    'cost_distribution' => array(
        'adwords' => 475,
),
    'create' => array(),
    'new_title2' => 'See Inventory, Prices & Offers',
    'new_descs' => array(
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '735-158-5956',
    'banner' => array(
        'template' => 'whitewatermotors',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17615',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);