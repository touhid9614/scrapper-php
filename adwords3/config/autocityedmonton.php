<?php

global $CronConfigs;
$CronConfigs["autocityedmonton"] = array(
    'password' => 'autocityedmonton',
    "email" => "regan@smedia.ca",
    'log' => false,
    "banner" => array(
        "template" => "autocityedmonton",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'adf_to' => [
        'Leads@autocityedmotnon.com',
    ],
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        //        'request-a-quote'  => [
        //            'url-match' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        //            'target'    => null,        //Don't move button
        //            'locations' => [
        //                'default'   => null,    //Don't need to change location
        //            ],
        //            'action-target' => 'a[data-href*="eprice"',
        //            'css-class' => 'a[data-href*="eprice"',
        //            'css-hover' => 'a[data-href*="eprice":hover',
        //            'button_action' => ['form','e-price'],
        //            'sizes'     => [
        //                '100'   => [
        //
        //                ]
        //            ],
        //            'texts'     => [
        //                'request-a-quote'  => [
        //                    'target'    => 'a[data-href*="eprice"',
        //                    'values'    => [
        //                        'Get E-Price',
        //                        'Get Internet Price',
        //                        'Get Your Price',
        //                        'Get Our Best Price'
        //                    ]
        //                ]
        //            ],
        //            'styles'    => [
        //                'orange'  => [
        //                    'normal'    => [
        //                        'background' => '#f06b20',
        //                        'border-color'     => '#f06b20'
        //                    ],
        //                    'hover'     => [
        //                        'background' => '#cf540e',
        //                        'border-color'     => '#cf540e'
        //                    ]
        //                ],
        //                'red'  => [
        //                    'normal'    => [
        //                        'background' => '#e01212',
        //                        'border-color'     => '#e01212'
        //                    ],
        //                    'hover'     => [
        //                        'background' => '#c60c0d',
        //                        'border-color'     => '#c60c0d'
        //                    ]
        //                ],
        //                'green'  => [
        //                    'normal'    => [
        //                        'background' => '#54b740',
        //                        'border-color'     => '#54b740'
        //                    ],
        //                    'hover'     => [
        //                        'background' => '#359d22',
        //                        'border-color'     => '#359d22'
        //                    ]
        //                ],
        //                'blue'  => [
        //                    'normal'    => [
        //                        'background' => '#1ca0d1',
        //                        'border-color'     => '#1ca0d1'
        //                    ],
        //                    'hover'     => [
        //                        'background' => '#188bb7',
        //                        'border-color'     => '#188bb7'
        //                    ]
        //                ]
        //            ]
        //        ],
        'trade-in' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.btn.btn-primary.btn-lg.dialog.btn-block',
            'css-class' => 'div.btn.btn-primary.btn-lg.dialog.btn-block',
            'css-hover' => 'div.btn.btn-primary.btn-lg.dialog.btn-block:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.btn.btn-primary.btn-lg.dialog.btn-block',
                    'values' => array(
                        'Appraise my trade in',
                        'We\'ll Buy Your Car',
                        'What\'s your trade worth?',
                        'We want your car',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*="finance-form"]',
            'css-class' => 'a[href*="finance-form"]',
            'css-hover' => 'a[href*="finance-form"]:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*="finance-form"]',
                    'values' => array(
                        'No hassle financing',
                        'Special Finance Offers',
                        'Get Financed Today',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.links-list.testDrive.ddc-content a.btn.btn-primary',
            'css-class' => 'div.links-list.testDrive.ddc-content a.btn.btn-primary',
            'css-hover' => 'div.links-list.testDrive.ddc-content a.btn.btn-primary:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.links-list.testDrive.ddc-content a.btn.btn-primary',
                    'values' => array(
                        'Book Test Drive',
                        'Schedule Test Visit',
                        'Test Drive Now',
                        'Test Drive today',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],
);