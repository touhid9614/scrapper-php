<?php

global $CronConfigs;

$CronConfigs["countrylincoln"] = array(
    'password' => 'countrylincoln',
    "email" => "regan@smedia.ca",
    'log' => false,
    "banner" => array(
        "template" => "countrylincoln",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [//[# Price Watch]
            'url-match' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
            'target' => null, //Don't move button
            'locations' => [
                'default' => null, //Don't need to change location
            ],
            'action-target' => 'span.smedia-ai-Used-request-a-quote',
            'css-class' => 'span.smedia-ai-Used-request-a-quote',
            'css-hover' => 'span.smedia-ai-Used-request-a-quote:hover',
            'button_action' => ['form','e-price'],
            'sizes' => [
                '100' => [
                ]
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'span.smedia-ai-Used-request-a-quote',
                    'values' => [
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price'
                    ]
                ]
            ],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background' => '#2e9015',
                        'border-color' => '#f06b20'
                    ],
                    'hover' => [
                        'background' => '#cf540e',
                        'border-color' => '#cf540e'
                    ]
                ],
                'red' => [
                    'normal' => [
                        'background' => '#ff6900',
                        'border-color' => '#e01212'
                    ],
                    'hover' => [
                        'background' => '#c60c0d',
                        'border-color' => '#c60c0d'
                    ]
                ],
                'green' => [
                    'normal' => [
                        'background' => '#2a6dbf',
                        'border-color' => '#54b740'
                    ],
                    'hover' => [
                        'background' => '#359d22',
                        'border-color' => '#359d22'
                    ]
                ],
                'blue' => [
                    'normal' => [
                        'background' => '#f80018',
                        'border-color' => '#1ca0d1'
                    ],
                    'hover' => [
                        'background' => '#188bb7',
                        'border-color' => '#188bb7'
                    ]
                ]
            ]
        ],
        'trade-in' => [//[# Buy It Now]
            'url-match' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
            'target' => null, //Don't move button
            'locations' => [
                'default' => null, //Don't need to change location
            ],
            'action-target' => 'span.smedia-ai-Used-financing',
            'css-class' => 'span.smedia-ai-Used-financing',
            'css-hover' => 'span.smedia-ai-Used-financing:hover',
            'sizes' => [
                '100' => [
                ]
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'span.smedia-ai-Used-financing',
                    'values' => [
                        'Purchase Now',
                        'Purchase Today',
                        'Buy It Today',
                        'Purchase It Now',
                        'Buy This Vehicle',
                        'Buy Today'
                    ]
                ]
            ],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background' => '#2e9015',
                        'border-color' => '#f06b20'
                    ],
                    'hover' => [
                        'background' => '#cf540e',
                        'border-color' => '#cf540e'
                    ]
                ],
                'red' => [
                    'normal' => [
                        'background' => '#ff6900',
                        'border-color' => '#e01212'
                    ],
                    'hover' => [
                        'background' => '#c60c0d',
                        'border-color' => '#c60c0d'
                    ]
                ],
                'green' => [
                    'normal' => [
                        'background' => '#2a6dbf',
                        'border-color' => '#54b740'
                    ],
                    'hover' => [
                        'background' => '#359d22',
                        'border-color' => '#359d22'
                    ]
                ],
                'blue' => [
                    'normal' => [
                        'background' => '#f80018',
                        'border-color' => '#1ca0d1'
                    ],
                    'hover' => [
                        'background' => '#188bb7',
                        'border-color' => '#188bb7'
                    ]
                ]
            ]
        ],
        'form-submit' => [
            'url-match' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
            'target' => null, //Don't move button
            'locations' => [
                'default' => null, //Don't need to change location
            ],
            'action-target' => 'button#link_contact_seller',
            'css-class' => 'button#link_contact_seller',
            'css-hover' => 'button#link_contact_seller',
            'button_action' => ['form','test-drive'],
            'sizes' => [
                '100' => [
                ]
            ],
            'texts' => [
                'financing' => [
                    'target' => 'button#link_contact_seller',
                    'values' => [
                        'Get More Info',
                        'Request Info',
                        'Request More Info',
                        'Send Request',
                        'Learn More'
                    ]
                ]
            ],
            'styles' => [
                'orange' => [
                    'normal' => [
                        'background' => '#2e9015',
                        'border-color' => '#f06b20'
                    ],
                    'hover' => [
                        'background' => '#cf540e',
                        'border-color' => '#cf540e'
                    ]
                ],
                'red' => [
                    'normal' => [
                        'background' => '#ff6900',
                        'border-color' => '#e01212'
                    ],
                    'hover' => [
                        'background' => '#c60c0d',
                        'border-color' => '#c60c0d'
                    ]
                ],
                'green' => [
                    'normal' => [
                        'background' => '#2a6dbf',
                        'border-color' => '#54b740'
                    ],
                    'hover' => [
                        'background' => '#359d22',
                        'border-color' => '#359d22'
                    ]
                ],
                'blue' => [
                    'normal' => [
                        'background' => '#f80018',
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
