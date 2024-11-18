<?php

global $CronConfigs;
$CronConfigs["gmcarsbynelson"] = array(
    'password' => 'gmcarsbynelson',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 1500,
    'bing_account_id' => 156003423,
    'bing_create' => array(
        'new_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 1500,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'title2' => 'Create Your Deal Online',
            'title3' => 'GR Chevrolet Buick GMC',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Create Your Deal Online',
            'title3' => 'GR Chevrolet Buick GMC',
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
    'customer_id' => '362-028-9595',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'gmcarsbynelson',
        'old_price_new' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more info!',
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
        0 => 'leads@grchevrolet.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button.stat-button-link',
            'css-class' => 'a.di-modal.main-cta.vdp-pricebox-cta-button.stat-button-link',
            'css-hover' => 'a.di-modal.main-cta.vdp-pricebox-cta-button.stat-button-link:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button.stat-button-link',
                    'values' => array(
                        0 => 'Inquire Now',
                        1 => 'Inquire Today',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B7750E,#F1901A)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C930C,#15C015)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17541',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '60',
),
    'name' => 'gmcarsbynelson',
);