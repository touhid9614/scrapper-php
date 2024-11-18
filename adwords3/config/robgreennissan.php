<?php

global $CronConfigs;
$CronConfigs["robgreennissan"] = array(
    "name" => " robgreennissan",
    "email" => "regan@smedia.ca",
    "password" => " robgreennissan",
    "log" => true,
    "banner" => array(
        "template" => "robgreennissan",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'adf_to' => array(
        'leads@robgreennh.motosnap.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name=6fd6a8af-68d9-4fb0-8fa0-35c1b7808719]',
            'css-class' => 'a[name="6fd6a8af-68d9-4fb0-8fa0-35c1b7808719"]',
            'css-hover' => 'a[name="6fd6a8af-68d9-4fb0-8fa0-35c1b7808719"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=6fd6a8af-68d9-4fb0-8fa0-35c1b7808719]',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name=d8beb5fb-e566-40f8-94a4-898d3d5d1b58]',
            'css-class' => 'a[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]',
            'css-hover' => 'a[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=d8beb5fb-e566-40f8-94a4-898d3d5d1b58]',
                    'values' => array(
                        'Get Price Alerts',
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name=3ad202f5-1c6d-42cf-b657-540f87079e5e]',
            'css-class' => 'a[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]',
            'css-hover' => 'a[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=3ad202f5-1c6d-42cf-b657-540f87079e5e]',
                    'values' => array(
                        'Request More Info',
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
    ],
);