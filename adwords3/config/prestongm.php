<?php

global $CronConfigs;
$CronConfigs["prestongm"] = array(
    'bid' => 3.0,
    'password' => 'prestongm',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'max_cost' => 300,
    'cost_distribution' => array(
        'new' => 100,
        'used' => 200,
),
    'post_code' => 'V3A 4Y1',
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'trackers' => array(
        'new_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
),
    'create' => array(
        'new_search' => true,
        'used_search' => true,
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
    'customer_id' => '868-572-4419',
    'banner' => array(
        'template' => 'prestongm',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#000',
        'styels' => array(
            'new_display' => 'quick_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_combined' => 'quick_banner',
            'used_combined' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'adf_to' => array(
        0 => array(
            'white' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#,#)',
                    'border-color' => null,
                    'font-family' => 'ed-icons, roboto',
),
                'hover' => array(
                    'background' => 'linear-gradient(#,#)',
                    'border-color' => null,
),
),
            'yellow' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#B38727,#B38727)',
                    'border-color' => '1CA0D1',
                    'color' => '#fff',
                    'font-family' => 'ed-icons, roboto',
),
                'hover' => array(
                    'background' => 'linear-gradient(#801608,#801608)',
                    'border-color' => '188BB7',
                    'color' => '#fff',
),
),
            'red' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#CC0000,#CC0000)',
                    'border-color' => 'E01212',
                    'color' => '#fff',
                    'font-family' => 'ed-icons, roboto',
),
                'hover' => array(
                    'background' => 'linear-gradient(#801608,#801608)',
                    'border-color' => 'C60C0D',
                    'color' => '#fff',
),
),
            'blue' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#0267BD,#0267BD)',
                    'border-color' => '1CA0D1',
                    'color' => '#fff',
                    'font-family' => 'ed-icons, roboto',
),
                'hover' => array(
                    'background' => 'linear-gradient(#801608,#801608)',
                    'border-color' => '188BB7',
                    'color' => '#fff',
),
),
            'black' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#1A1A1A,#1A1A1A)',
                    'border-color' => '1CA0D1',
                    'color' => '#fff',
                    'font-family' => 'ed-icons, roboto',
),
                'hover' => array(
                    'background' => 'linear-gradient(#801608,#801608)',
                    'border-color' => '188BB7',
                    'color' => '#fff',
),
),
),
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => array(
        'Used test-drive' => array(
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-class' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-hover' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
                    'values' => array(
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Get Trade In Value',
                        'What\'s Your Trade Worth?',
                        'Trade In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
),
),
),
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B38727,#B38727)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0267BD,#0267BD)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A1A1A,#1A1A1A)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-class' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-hover' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'div.row.vdp-all-ctas-container div:nth-of-type(4) button',
                    'values' => array(
                        0 => 'Schedule a Test Drive',
                        1 => 'Schedule Your Test Drive',
                        2 => 'Request A Test Drive',
                        3 => 'Book Test Drive',
                        4 => 'Test Drive Now',
),
),
),
            'styles' => array(
                'white' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F7F6F5,#F7F6F5)',
                        'border-color' => '#1ca0d1',
                        // 'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABAAA9,#ABAAA9)',
                        'border-color' => '#188bb7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B38727,#B38727)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0267BD,#0267BD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A1A1A,#1A1A1A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.vdp-all-ctas-container div:nth-of-type(2) button',
            'css-class' => 'div.row.vdp-all-ctas-container div:nth-of-type(2) button',
            'css-hover' => 'div.row.vdp-all-ctas-container div:nth-of-type(2) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'div.row.vdp-all-ctas-container div:nth-of-type(2) button',
                    'values' => array(
                        0 => 'What\'s Your Trade Worth?',
                        1 => 'Value Your Trade',
                        2 => 'Get Trade In Value',
                        3 => 'We\'ll Buy Your Car',
                        4 => 'Trade In Offer',
                        5 => 'Trade In Your Ride',
                        6 => 'We Want Your Car',
),
),
),
            'styles' => array(
                'white' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F7F6F5,#F7F6F5)',
                        'border-color' => '#1ca0d1',
                        // 'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABAAA9,#ABAAA9)',
                        'border-color' => '#188bb7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B38727,#B38727)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0267BD,#0267BD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A1A1A,#1A1A1A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
),
        'Used trade-in' => array(
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.vdp-all-ctas-container div:nth-of-type(3) button',
            'css-class' => 'div.row.vdp-all-ctas-container div:nth-of-type(3) button',
            'css-hover' => 'div.row.vdp-all-ctas-container div:nth-of-type(3) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'div.row.vdp-all-ctas-container div:nth-of-type(3) button',
                    'values' => array(
                        0 => 'Value Your Trade',
                        1 => 'We\'ll Buy Your Car',
                        2 => 'Get Trade In Value',
                        3 => 'What\'s Your Trade Worth?',
                        4 => 'Trade In Offer',
                        5 => 'Trade In Your Ride',
                        6 => 'We Want Your Car',
),
),
),
            'styles' => array(
                'white' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F7F6F5,#F7F6F5)',
                        'border-color' => '#1ca0d1',
                        // 'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABAAA9,#ABAAA9)',
                        'border-color' => '#188bb7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B38727,#B38727)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0267BD,#0267BD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A1A1A,#1A1A1A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
),
),
    'name' => 'prestongm',
);