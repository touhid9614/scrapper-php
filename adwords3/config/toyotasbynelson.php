<?php

global $CronConfigs;
$CronConfigs["toyotasbynelson"] = array(
    'password' => 'toyotasbynelson',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 750,
    'bing_account_id' => 156003418,
    'bing_create' => array(
        'new_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 750,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'title2' => 'Create Your Deal Online',
            'title3' => 'Nelson Toyota',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Create Your Deal Online',
            'title3' => 'Nelson Toyota',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '543-764-6037',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'toyotasbynelson',
        'old_price_new' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today.',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'adf_to' => array(
        0 => 'leads@nelsontoyota.net',
),
    'form_live' => false,
    'buttons_live' => false,
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17536',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#EA2627',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#EA2627',
        'coupon_validity' => '60',
),
    'name' => 'toyotasbynelson',
);