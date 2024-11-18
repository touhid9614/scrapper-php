<?php

global $CronConfigs;
$CronConfigs["autosbynelson"] = array(
    'password' => 'autosbynelson',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 18500,
    'bing_account_id' => 156003424,
    'bing_create' => array(
        'used_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 18500,
),
    'create' => array(),
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
            'title2' => 'Shop & Finance Online',
            'title3' => 'Autos By Nelson',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Autos By Nelson',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
),
    'customer_id' => '512-027-9350',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'autosbynelson',
        'old_price_new' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17549',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#EA2627',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#EA2627',
        'coupon_validity' => '60',
),
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[data-href*=eprice]',
            'css-class' => 'a[data-href*=eprice]',
            'css-hover' => 'a[data-href*=eprice]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[data-href*=eprice]',
                    'values' => array(
                        0 => 'Get Your Price',
                        1 => 'Get Our Best Price',
                        2 => 'Local Pricing',
                        3 => 'Best Price',
                        4 => 'Get Current Market Price',
                        5 => 'Get Details',
                        6 => 'Get Internet Price Now',
                        7 => 'Get e-price',
                        8 => 'Get your Price!',
                        9 => 'Confirm Availability',
                        10 => 'Get Your Exclusive Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
            'css-class' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
            'css-hover' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
                    'values' => array(
                        0 => 'Get Trade-In Value',
                        1 => 'Value Your Trade',
                        2 => 'Trade Offer',
                        3 => 'What\'s Your Trade Worth?',
                        4 => 'We Want Your Car!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href *=schedule]',
            'css-class' => 'a[href *=schedule]',
            'css-hover' => 'a[href *=schedule]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href *=schedule]',
                    'values' => array(
                        0 => 'Request a Test Drive',
                        1 => 'Test Drive Now',
                        2 => 'Test Drive Today',
                        3 => 'Want To Test Drive',
                        4 => 'Schedule My Visit',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'name' => 'autosbynelson',
);