<?php

global $CronConfigs;

$CronConfigs["bigvalleyautoford"] = array(
    'password' => 'bigvalleyautoford',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "bigvalleyautoford",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
            'target' => null, //Don't move button
            'locations' => [
                'default' => null, //Don't need to change location
            ],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'sizes' => [
                '100' => [
                //'font-size' => '1.4rem'
                ]
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => [
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing'
                    ]
                ]
            ],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background' => '#f06b20',
                        'border-color' => '#f06b20'
                    ],
                    'hover' => [
                        'background' => '#cf540e',
                        'border-color' => '#cf540e'
                    ]
                ],
                'red' => [
                    'normal' => [
                        'background' => '#e01212',
                        'border-color' => '#e01212'
                    ],
                    'hover' => [
                        'background' => '#c60c0d',
                        'border-color' => '#c60c0d'
                    ]
                ],
                'green' => [
                    'normal' => [
                        'background' => '#54b740',
                        'border-color' => '#54b740'
                    ],
                    'hover' => [
                        'background' => '#359d22',
                        'border-color' => '#359d22'
                    ]
                ],
                'blue' => [
                    'normal' => [
                        'background' => '#1ca0d1',
                        'border-color' => '#1ca0d1'
                    ],
                    'hover' => [
                        'background' => '#188bb7',
                        'border-color' => '#188bb7'
                    ]
                ]
            ]
        ],
        'test-drive' => [
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
            'target' => null, //Don't move button
            'locations' => [
                'default' => null, //Don't need to change location
            ],
            'action-target' => 'a.btn.btn-success.dialog.btn-block.btn-lg',
            'css-class' => 'a.btn.btn-success.dialog.btn-block.btn-lg',
            'css-hover' => 'a.btn.btn-success.dialog.btn-block.btn-lg:hover',
            'sizes' => [
                '100' => [
                ]
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.btn.btn-success.dialog.btn-block.btn-lg',
                    'values' => [
                        'Test drive',
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today'
                    ]
                ]
            ],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background' => '#f06b20',
                        'border-color' => '#f06b20'
                    ],
                    'hover' => [
                        'background' => '#cf540e',
                        'border-color' => '#cf540e'
                    ]
                ],
                'red' => [
                    'normal' => [
                        'background' => '#e01212',
                        'border-color' => '#e01212'
                    ],
                    'hover' => [
                        'background' => '#c60c0d',
                        'border-color' => '#c60c0d'
                    ]
                ],
                'green' => [
                    'normal' => [
                        'background' => '#54b740',
                        'border-color' => '#54b740'
                    ],
                    'hover' => [
                        'background' => '#359d22',
                        'border-color' => '#359d22'
                    ]
                ],
                'blue' => [
                    'normal' => [
                        'background' => '#1ca0d1',
                        'border-color' => '#1ca0d1'
                    ],
                    'hover' => [
                        'background' => '#188bb7',
                        'border-color' => '#188bb7'
                    ]
                ]
            ]
        ]
    ]
);
