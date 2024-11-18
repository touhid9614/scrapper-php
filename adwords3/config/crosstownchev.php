<?php

global $CronConfigs;

$CronConfigs["crosstownchev"] = array(
    'password' => 'crosstownchev',
    "email" => "regan@smedia.ca",
    'log' => true,
    //'max_cost'      => 1050,
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes
    ),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    //'customer_id'   => '893-139-3829',
    "banner" => array(
        "template" => "crosstownchev",
        'fb_description' => 'Are you still interested in the [year] [make] [model] ?',
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner"
        ),
        "font_color" => "#ffffff"
    ),
//    'buttons_live' => false,
//    'buttons' => [
//        'request-a-quote' => [
//            'url-match' => '/\/VehicleDetails\//i',
//            'target' => null, //Don't move button
//            'locations' => [
//                'default' => null, //Don't need to change location
//            ],
//            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
//            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
//            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
//            'sizes' => [
//                '100' => [
//                ]
//            ],
//            'texts' => [
//                'request-a-quote' => [
//                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
//                    'values' => [
//                        'Request A Quote',
//                        'Get E Price Now!',
//                        'Internet Price',
//                        'Get your Price!',
//                        'E- Price',
//                        'Get Internet Price Now!',
//                        'Get Our Best Price',
//                        'Best Price',
//                        'Local Pricing',
//                        'Special Pricing!',
//                        'Get Active Market Price',
//                        'Get Market Price',
//                        'Market Pricing'
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
//        'test-drive' => [
//            'url-match' => '/\/VehicleDetails\//i',
//            'target' => null, //Don't move button
//            'locations' => [
//                'default' => null, //Don't need to change location
//            ],
//             'action-target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
//            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
//            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
//            'sizes' => [
//                '100' => [
//                ]
//            ],
//            'texts' => [
//                'financing' => [
//                    'target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
//                    'values' => [
//                        'Test drive',
//                        'Book Test Drive',
//                        'Schedule Test Drive',
//                        'Test Drive Now',
//                        'Test Drive today'
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
//        ]
//    ]
);
