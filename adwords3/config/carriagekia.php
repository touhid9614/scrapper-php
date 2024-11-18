<?php

global $CronConfigs;
$CronConfigs["carriagekia"] = array(
    'name' => 'carriagekia',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'email' => 'regan@smedia.ca',
    'password' => 'carriagekia',
    'log' => true,
    'customer_id' => '723-287-8742',
    'max_cost' => 3250,
    'cost_distribution' => array(
        'adwords' => 3250,
),
    'banner' => array(
        'template' => 'carriagekia',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17929',
        'promotion_text' => '$25 Gift Card',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);