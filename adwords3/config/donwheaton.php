<?php

global $CronConfigs;
$CronConfigs["donwheaton"] = array(
    'password' => 'donwheaton',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "donwheaton",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#072E61',
            '#072E61',
),
        'button_color_hover' => array(
            '#041731',
            '#041731',
),
        'button_color_active' => array(
            '#041731',
            '#041731',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Don Wheaton GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Don Wheaton Team',
        'forward_to' => array(
            'leads@wheatonhonda.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'service' => '',
),
),
    'lead_to' => [
        'leads@donwheaton.net',
],
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        //        'request-a-quote' => [
        //            'url-match' => '/\/VehicleDetails\/(?:new|used|certified)-/i',
        //            'target' => null, //Don't move button
        //            'locations' => [
        //                'default' => null, //Don't need to change location
        //            ],
        //            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
        //            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
        //            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
        //            'button_action' => ['form', 'e-price'],
        //            'sizes' => [
        //                '100' => [
        //                    'font-size' => '1.4rem'
        //                ]
        //            ],
        //            'texts' => [
        //                'request-a-quote' => [
        //                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
        //                    'values' => [
        //                        'GET E-PRICE',
        //                        'GET INTERNET PRICE',
        //                        'GET YOUR PRICE',
        //                        'GET OUR BEST PRICE',
        //                        'GET MORE INFO',
        //                        'ASK A QUESTION',
        //                    ]
        //                ]
        //            ],
        //            'styles' => [
        //                'orange' => [
        //                    'normal' => [
        //                        'background' => '#f06b20',
        //                        'border-color' => '#f06b20'
        //                    ],
        //                    'hover' => [
        //                        'background' => '#cf540e',
        //                        'border-color' => '#cf540e'
        //                    ]
        //                ],
        //                'red' => [
        //                    'normal' => [
        //                        'background' => '#e01212',
        //                        'border-color' => '#e01212'
        //                    ],
        //                    'hover' => [
        //                        'background' => '#c60c0d',
        //                        'border-color' => '#c60c0d'
        //                    ]
        //                ],
        //                'green' => [
        //                    'normal' => [
        //                        'background' => '#54b740',
        //                        'border-color' => '#54b740'
        //                    ],
        //                    'hover' => [
        //                        'background' => '#359d22',
        //                        'border-color' => '#359d22'
        //                    ]
        //                ],
        //                'blue' => [
        //                    'normal' => [
        //                        'background' => '#1ca0d1',
        //                        'border-color' => '#1ca0d1'
        //                    ],
        //                    'hover' => [
        //                        'background' => '#188bb7',
        //                        'border-color' => '#188bb7'
        //                    ]
        //                ]
        //            ]
        //        ],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
                    'values' => [
                        'TEST DRIVE TODAY',
                        'SCHEDULE A TEST DRIVE',
                        'SCHEDULE MY VISIT',
],
],
],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
],
                    'hover' => [
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
],
],
                'red' => [
                    'normal' => [
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
],
                    'hover' => [
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
],
],
                'green' => [
                    'normal' => [
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
],
                    'hover' => [
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
],
],
                'blue' => [
                    'normal' => [
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
],
                    'hover' => [
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
],
],
],
],
        'trade-in' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name=8daeea41-ea2c-4caa-8ffa-cba8935d260a]',
            'css-class' => 'a[name="8daeea41-ea2c-4caa-8ffa-cba8935d260a"]',
            'css-hover' => 'a[name="8daeea41-ea2c-4caa-8ffa-cba8935d260a"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[name=8daeea41-ea2c-4caa-8ffa-cba8935d260a]',
                    'values' => [
                        'GET TRADE-IN VALUE',
                        'TRADE OFFER',
                        'WHAT IS YOUR TRADE WORTH?',
                        'WE WANT YOUR CAR',
                        "WE'LL BUY YOUR CAR",
],
],
],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
],
                    'hover' => [
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
],
],
                'red' => [
                    'normal' => [
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
],
                    'hover' => [
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
],
],
                'green' => [
                    'normal' => [
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
],
                    'hover' => [
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
],
],
                'blue' => [
                    'normal' => [
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
],
                    'hover' => [
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
],
],
],
],
        'financing' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name=c13997d4-92c9-405a-acbb-4b32263e6758]',
            'css-class' => 'a[name="c13997d4-92c9-405a-acbb-4b32263e6758"]',
            'css-hover' => 'a[name="c13997d4-92c9-405a-acbb-4b32263e6758"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[name=c13997d4-92c9-405a-acbb-4b32263e6758]',
                    'values' => [
                        'NO HASSLE FINANCING',
                        'GET FINANCED TODAY',
                        'EXPLORE PAYMENTS',
                        'SPECIAL FINANCE OFFERS',
                        'FINANCING AVAILABLE',
],
],
],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
],
                    'hover' => [
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
],
],
                'red' => [
                    'normal' => [
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
],
                    'hover' => [
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
],
],
                'green' => [
                    'normal' => [
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
],
                    'hover' => [
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
],
],
                'blue' => [
                    'normal' => [
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
],
                    'hover' => [
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
],
],
],
],
],
);