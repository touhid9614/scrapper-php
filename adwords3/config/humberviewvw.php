<?php

global $CronConfigs;
$CronConfigs["humberviewvw"] = array(
    "name" => " humberviewvw",
    "email" => "regan@smedia.ca",
    "password" => " humberviewvw",
    "log" => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.inventory-details__header-cta a.link__alpha.link__alpha-primary',
            'css-class' => 'div.inventory-details__header-cta a.link__alpha.link__alpha-primary',
            'css-hover' => 'div.inventory-details__header-cta a.link__alpha.link__alpha-primary:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.inventory-details__header-cta a.link__alpha.link__alpha-primary',
                    'values' => array(
                        'Get a Quote',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Special Pricing',
                        'Inquire Now',
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=road-test].link__beta-primary',
            'css-class' => 'a[href*=road-test].link__beta-primary',
            'css-hover' => 'a[href*=road-test].link__beta-primary:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=road-test].link__beta-primary',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Schedule My Visit',
                        'Want to Test Drive It?',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#f05f40',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#e01212',
                        'color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#b23850',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00887a',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00887a',
                        'color' => '#ffffff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00638c',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00638c',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=trade-in].link__beta-primary',
            'css-class' => 'a[href*=trade-in].link__beta-primary',
            'css-hover' => 'a[href*=trade-in].link__beta-primary:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade-in].link__beta-primary',
                    'values' => array(
                        'Value Your Trade',
                        'Get Trade-In Value',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'What\'s Your Trade Worth?',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#f05f40',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#e01212',
                        'color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#b23850',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00887a',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00887a',
                        'color' => '#ffffff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00638c',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00638c',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=financing].link__beta-primary',
            'css-class' => 'a[href*=financing].link__beta-primary',
            'css-hover' => 'a[href*=financing].link__beta-primary:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing].link__beta-primary',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#f05f40',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#e01212',
                        'color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#b23850',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00887a',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00887a',
                        'color' => '#ffffff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient( #ffffff, #ffffff)',
                        'border-color' => '#00638c',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#00638c',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
    ],
);