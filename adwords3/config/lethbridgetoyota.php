<?php

global $CronConfigs;
$CronConfigs["lethbridgetoyota"] = array(
    'name' => 'lethbridgetoyota',
    'email' => 'regan@smedia.ca',
    'password' => 'lethbridgetoyota',
    'customer_id' => '286-723-5884',
    'log' => true,
    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bing_account_id' => 156002838,
    'max_cost' => 900,
    'create' => array(),
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
        'template' => 'lethbridgetoyota',
        'fb_description_new' => '[description]',
        'fb_lookalike_description_new' => 'Check out this NEW [year] [make] [model]! Click for more information.',
        'fb_description_used' => '[description]',
        'fb_lookalike_description_used' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'adf_to' => 'smedia@lethbridge-toyota.net',
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button#request-info',
            'css-class' => 'button#request-info',
            'css-hover' => 'button#request-info:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'button#request-info',
                    'values' => array(
                        'Request More Information',
                        'Get More Information',
                        'Get More Info Online',
                        'Let Our Experts Help',
                        'Ask for More Info',
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '0B498A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '0C4178',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button[data-target="#apply-for-financing-Modal"]',
            'css-class' => 'button[data-target="#apply-for-financing-Modal"]',
            'css-hover' => 'button[data-target="#apply-for-financing-Modal"]:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'button[data-target="#apply-for-financing-Modal"]',
                    'values' => array(
                        'Online Finance Application',
                        'Get Financed Online',
                        'Apply for Financing from Home',
                        'Get Approved Online',
                        'Apply for Financing',
                        'No hassle financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Explore Payments',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '0B498A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '0C4178',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'color' => '#fff',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'color' => '#fff',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'color' => '#fff',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'div button[onclick*=BookATestDrive]',
            'css-class' => 'div button[onclick*=BookATestDrive]',
            'css-hover' => 'div button[onclick*=BookATestDrive]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'div button[onclick*=BookATestDrive]',
                    'values' => array(
                        'Request at Home Test Drive',
                        'Schedule Your at Home Test Drive',
                        'Book Your at Home Test Drive',
                        'We\'ll Bring the Test Drive to You',
                        'Let Us Bring the Test Drive to You',
                        'Test Drive at Home',
                        'Schedule My Visit',
                        'Test Drive',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '0B498A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '0C4178',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'color' => '#fff',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'color' => '#fff',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'color' => '#fff',
),
),
),
),
),
    'cost_distribution' => array(
        'new' => 900,
        'used' => 0,
),
);