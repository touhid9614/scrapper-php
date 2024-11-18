<?php

global $CronConfigs;
$CronConfigs["kiasbynelson"] = array(
    'password' => 'kiasbynelson',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 900,
    'cost_distribution' => array(
        'adwords' => 900,
),
    'create' => array(),
    'bing_account_id' => 156003420,
    'bing_create' => array(
        'new_search' => true,
),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'customer_id' => '487-231-1950',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'kiasbynelson',
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
                        0 => 'Get E-Price',
                        1 => 'Inquire Now',
                        2 => 'Local Pricing',
                        3 => 'Best Price',
                        4 => 'Get Current Market Price',
                        5 => 'Get Details',
                        6 => 'Get Internet Price Now',
                        7 => 'Get your Price!',
                        8 => 'Confirm Availability',
                        9 => 'Get Your Exclusive Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C1801E,#C1801E)',
                        'border-color' => 'F06B20',
                        'padding' => '10px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
                        'padding' => '10px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B81D33,#B81D33)',
                        'border-color' => 'E01212',
                        'padding' => '10px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
                        'padding' => '10px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3BA41A,#3BA41A)',
                        'border-color' => '54B740',
                        'padding' => '10px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '359D22',
                        'padding' => '10px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
                        'border-color' => '1CA0D1',
                        'padding' => '10px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding' => '10px',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=schedule].btn',
            'css-class' => 'a[href*=schedule].btn',
            'css-hover' => 'a[href*=schedule].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*=schedule].btn',
                    'values' => array(
                        0 => 'Book a Test Drive',
                        1 => 'Test Drive Now',
                        2 => 'Test Drive Today',
                        3 => 'Want to Test Drive?',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C1801E,#C1801E)',
                        'border-color' => 'F06B20',
                        'width' => '100%',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
                        'width' => '100%',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B81D33,#B81D33)',
                        'border-color' => 'E01212',
                        'width' => '100%',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
                        'width' => '100%',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3BA41A,#3BA41A)',
                        'border-color' => '54B740',
                        'width' => '100%',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '359D22',
                        'width' => '100%',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
                        'border-color' => '1CA0D1',
                        'width' => '100%',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'width' => '100%',
),
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17537',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#EA2627',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#EA2627',
        'coupon_validity' => '60',
),
    'name' => 'kiasbynelson',
);