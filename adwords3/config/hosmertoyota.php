<?php

global $CronConfigs;
$CronConfigs["hosmertoyota"] = array(
    "name" => " hosmertoyota",
    "email" => "regan@smedia.ca",
    "password" => " hosmertoyota",
    'log' => true,
    "banner" => array(
        "template" => "hosmertoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.vdp-vehicle-pricing-toolbar button:nth-of-type(1)',
            'css-class' => 'div.vdp-vehicle-pricing-toolbar button:nth-of-type(1)',
            'css-hover' => 'div.vdp-vehicle-pricing-toolbar button:nth-of-type(1):hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.vdp-vehicle-pricing-toolbar button:nth-of-type(1)',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Pricing',
                        'Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AD1C24,#AD1C24)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D31920,#D31920)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'Listing request-a-quote' => [
            'url-match' => '/\\/inventory\\?type=(?:new|used)/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.medium-4.medium-push-8.columns button.button',
            'css-class' => 'div.medium-4.medium-push-8.columns button.button',
            'css-hover' => 'div.medium-4.medium-push-8.columns button.button:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.medium-4.medium-push-8.columns button.button',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Pricing',
                        'Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AD1C24,#AD1C24)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D31920,#D31920)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=credit].button',
            'css-class' => 'a[href*=credit].button',
            'css-hover' => 'a[href*=credit].button:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=credit].button',
                    'values' => array(
                        'Financing Available',
                        'Apply for Financing',
                        'Special Finance Offers',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AD1C24,#AD1C24)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D31920,#D31920)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=trade].button',
            'css-class' => 'a[href*=trade].button',
            'css-hover' => 'a[href*=trade].button:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade].button',
                    'values' => array(
                        'Get Trade-In Value',
                        'Appraise Your Trade',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'We\'ll Buy Your Car',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AD1C24,#AD1C24)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D31920,#D31920)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],
);