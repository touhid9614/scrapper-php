<?php

global $CronConfigs;
$CronConfigs["tacomaminicom"] = array(
    'password' => 'tacomaminicom',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'max_cost' => 350,
    'cost_distribution' => array(
        'adwords' => 350,
),
    'create' => array(
        'new_search' => true,
        'used_search' => true,
),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
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
    'customer_id' => '802-339-3474',
    'banner' => array(
        'template' => 'tacomaminicom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click to learn more.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for further information.',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to get our best price.',
        'hst' => true,
        'flash_style' => 'default',
        //'fb_style' => 'tacomaminicom',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'adf_to' => array(
        'nwmini@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[data-href*=eprice]',
            'css-class' => 'a[data-href*=eprice]',
            'css-hover' => 'a[data-href*=eprice]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[data-href*=eprice]',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
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
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[data-href*=schedule]',
            'css-class' => 'a[data-href*=schedule]',
            'css-hover' => 'a[data-href*=schedule]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[data-href*=schedule]',
                    'values' => array(
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive today',
                        'TEST RIDE',
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
),
),
        'request-information' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[data-href*=lead]',
            'css-class' => 'a[data-href*=lead]',
            'css-hover' => 'a[data-href*=lead]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => 'a[data-href*=lead]',
                    'values' => array(
                        'Get More Information',
                        'Request Information',
                        'Book Test Drive',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Let our Experts Help',
                        'Ask an Expert',
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
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=preapproved].btn-default.btn.btn-block',
            'css-class' => 'a[href*=preapproved].btn-default.btn.btn-block',
            'css-hover' => 'a[href*=preapproved].btn-default.btn.btn-block:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a[href*=preapproved].btn-default.btn.btn-block',
                    'values' => array(
                        'No hassle financing',
                        'Financing Available',
                        'Explore Payments',
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
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17716',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'proxy-area' => 'CA',
    'name' => 'tacomaminicom',
);