<?php

global $CronConfigs;
$CronConfigs["carriagemitsubishi"] = array(
    'name' => 'carriagemitsubishi',
    'email' => 'regan@smedia.ca',
    'password' => 'carriagemitsubishi',
    'log' => true,
    'customer_id' => '521-046-8909',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'carriagemitsubishi',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 2550,
    'cost_distribution' => array(
        'new' => 300,
        'used' => 2250,
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '18009',
        'promotion_text' => 'Call Us Today! 1-678-932-0545',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '60',
),
);