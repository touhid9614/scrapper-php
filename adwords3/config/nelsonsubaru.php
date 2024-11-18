<?php

global $CronConfigs;
$CronConfigs["nelsonsubaru"] = array(
    'password' => 'nelsonsubaru',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 750,
    'bing_account_id' => 156003419,
    'bing_create' => array(
        'new_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 750,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Nelson Subaru',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Nelson Subaru',
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
    'customer_id' => '598-068-1452',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'nelsonsubaru',
        'fb_description' => 'Are you still interested in the [year] [make] [model] - VIN: [vin]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] - VIN: [vin] today. Click for more information.',
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
        0 => 'leads@nelsonsubarukia.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.btn.btn-default.eprice.dialog.button.epriceLink',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button.epriceLink',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button.epriceLink:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.btn.btn-default.eprice.dialog.button.epriceLink',
                    'values' => array(
                        0 => 'Local Pricing',
                        1 => 'Best Price',
                        2 => 'Get Current Market Price',
                        3 => 'Get Details',
                        4 => 'Get Internet Price Now',
                        5 => 'Get e-price',
                        6 => 'Get your Price!',
                        7 => 'Confirm Availability',
                        8 => 'Get Your Exclusive Price',
),
),
),
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#C40001,#C40001)',
                        'border-color' => 'C40001',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#015130,#015130)',
                        'border-color' => '015130',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#305891,#305891)',
                        'border-color' => '305891',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.price-btn[href*="financing"]',
            'css-class' => '.price-btn[href*="financing"]',
            'css-hover' => '.price-btn[href*="financing"]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => '.price-btn[href*="financing"]',
                    'values' => array(
                        0 => 'Get Pre-Approved',
                        1 => 'Get Prequalified for Credit',
                        2 => 'Financing Available',
                        3 => 'Get Financed Today',
),
),
),
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#C40001,#C40001)',
                        'border-color' => 'C40001',
                        'color' => '#fff',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#015130,#015130)',
                        'border-color' => '015130',
                        'color' => '#fff',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#305891,#305891)',
                        'border-color' => '305891',
                        'color' => '#fff',
),
                    'hover' => array(
                        'padding' => '10px',
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17538',
        'promotion_text' => '$25 VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#1F2020',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#1F2020',
        'coupon_validity' => '60',
),
    'name' => 'nelsonsubaru',
);