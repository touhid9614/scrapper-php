<?php

global $CronConfigs;
$CronConfigs["manitoumainlinechrysler"] = array(
    'name' => 'manitoumainlinechrysler',
    'email' => 'regan@smedia.ca',
    'password' => 'manitoumainlinechrysler',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '407-053-8603',
    'max_cost' => 1470,
    'cost_distribution' => array(
        'adwords' => 1470,
),
    'bing_account_id' => 156002885,
    'create' => array(),
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
            'desc2' => '[year] [make] [model]',
),
),
    'lead' => null,
    'banner' => array(
        'template' => 'manitoumainlinechrysler',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? We have the deals in the province! Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! We have the deals in the province! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will get in touch to answer any question.',
        'fb_marketplace_description' => '[description]',
        'old_price_new' => 'msrp',
        'flash_style' => 'default',
        'border_color' => '#282828',
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
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => array(
        //get approved//
        'financing' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.vdp-price-box__main-cta-wrapper a[href*="/finance/apply-for-financing/"]',
            'css-class' => '.vdp-price-box__main-cta-wrapper a[href*="/finance/apply-for-financing/"]',
            'css-hover' => '.vdp-price-box__main-cta-wrapper a[href*="/finance/apply-for-financing/"]:hover',
            //             'button_action' => array(
            //                 'form',
            //                 'finance',
            // ),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => '.vdp-price-box__main-cta-wrapper a[href*="/finance/apply-for-financing/"]',
                    'values' => array(
                        'APPLY FOR FINANCING',
                        'FINANCING OPTIONS',
                        'GET FINANCED TODAY',
                        'GET APPROVED',
                        'SPECIAL FINANCE OFFERS',
                        'GET YOUR LOAN ONLINE',
                        'CALCULATE YOUR PAYMENTS',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3FB94D,#3FB94D)',
                        'border-color' => '3FB94D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#37A143,#37A143)',
                        'border-color' => '37A143',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1294EF,#1294EF)',
                        'border-color' => '1294EF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1184D6,#1184D6)',
                        'border-color' => '1184D6',
),
),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1184D6,#1184D6)',
                        'border-color' => '1184D6',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0067B0,#0067B0)',
                        'border-color' => '0067B0',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D60708,#D60708)',
                        'border-color' => 'D60708',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD0606,#BD0606)',
                        'border-color' => 'BD0606',
),
),
),
),
        //get e price//
        'request-a-quote' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-class' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-hover' => 'a.di-modal.main-cta.vdp-pricebox-cta-button:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
                    'values' => array(
                        'GET INTERNET PRICE NOW',
                        'GET A QUOTE',
                        'GET YOUR BEST PRICE',
                        'INTERNET PRICE',
                        'BEST PRICE',
                        'GET SPECIAL PRICE',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3FB94D,#3FB94D)',
                        'border-color' => '3FB94D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#37A143,#37A143)',
                        'border-color' => '37A143',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1294EF,#1294EF)',
                        'border-color' => '1294EF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1184D6,#1184D6)',
                        'border-color' => '1184D6',
),
),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1184D6,#1184D6)',
                        'border-color' => '1184D6',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0067B0,#0067B0)',
                        'border-color' => '0067B0',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D60708,#D60708)',
                        'border-color' => 'D60708',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD0606,#BD0606)',
                        'border-color' => 'BD0606',
),
),
),
),
),
);