<?php

global $CronConfigs;
$CronConfigs["performancefordbountiful"] = array(
    'password' => 'performancefordbountiful',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '239-770-7843',
    'max_cost' => 4213,
    'bing_account_id' => 156002887,
    'cost_distribution' => array(
        'adwords' => 4213,
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
    'banner' => array(
        'template' => 'performancefordbountiful',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click below, fill in your info to get $300 OFF internet price, and a product specialist will be in touch to aid in any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_search' => 'custom_banner',
            'used_search' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_combined' => 'custom_banner',
            'used_combined' => 'custom_banner',
            'new_placement' => 'custom_banner',
            'used_placement' => 'custom_banner',
),
),
    'fb_config' => array(
        'monthly_budget' => 200,
        'account_id' => '1280802995290994',
        'page_id' => '422529051220712',
        'pixel_id' => '421434184863306',
        'dataset' => '105720076784356',
        'form_id' => '',
        'action_types' => array(
            'click',
),
        'plain' => false,
        'include_stock' => false,
        'polk_data' => true,
        'targeting' => array(
            'desktop' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        array(
                            'key' => 3887,
                            'name' => 'Utah',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        'home',
),
),
                'publisher_platforms' => array(
                    'facebook',
),
                'facebook_positions' => array(
                    'feed',
),
                'device_platforms' => array(
                    'desktop',
),
),
            'mobile' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        array(
                            'key' => 3887,
                            'name' => 'Utah',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        'home',
),
),
                'publisher_platforms' => array(
                    'facebook',
),
                'facebook_positions' => array(
                    'feed',
),
                'device_platforms' => array(
                    'mobile',
),
),
),
),
    'adf_to' => array(
        'leads@performancefordlincoln.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href *=eprice-form]',
            'css-class' => 'a[href *=eprice-form]',
            'css-hover' => 'a[href *=eprice-form]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href *=eprice-form]',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'Get Our Best Price',
                        'Best Price',
                        'Special Pricing!',
                        'Get More Information',
                        'Get Market Price',
                        'Market Pricing',
                        'SPECIAL PRICING!',
                        'Request a Quote',
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href *=black-book-value-your-trade]',
            'css-class' => 'a[href *=black-book-value-your-trade]',
            'css-hover' => 'a[href *=black-book-value-your-trade]:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'a[href *=black-book-value-your-trade]',
                    'values' => array(
                        'We want your car',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
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
            'action-target' => 'a[href *=credit-plus]',
            'css-class' => 'a[href *=credit-plus]',
            'css-hover' => 'a[href *=credit-plus]:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a[href *=credit-plus]',
                    'values' => array(
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
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
        'enabled' => null,
        'client_id' => '17699',
        'promotion_text' => 'VISIT US TODAY!',
        'promotion_color' => '#2761AC',
        'overlay_color' => '#2761AC',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#2761AC',
        'coupon_validity' => '30',
),
    'name' => 'performancefordbountiful',
    'lead' => null,
);