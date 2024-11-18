<?php

global $CronConfigs;
$CronConfigs["saskatoonsouthhyundai"] = array(
    'password' => 'saskatoonsouthhyundai',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "saskatoonsouthhyundai",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    //  'lead_to'=>[],
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button[onclick*="requesteprice"]',
            'css-class' => 'button[onclick*="requesteprice"]',
            'css-hover' => 'button[onclick*="requesteprice"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button[onclick*="requesteprice"] span',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'Get Your Price!',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Inquire Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC7500,#CC7500)',
                        'border-color' => '#cc7500',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '#00a300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '#094e83',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button[onclick*=TRADE],a[onclick*=TRADE]',
            'css-class' => 'button[onclick*=TRADE],a[onclick*=TRADE]',
            'css-hover' => 'button[onclick*=TRADE],a[onclick*=TRADE]:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'button[onclick*=TRADE],a[onclick*=TRADE] span',
                    'values' => array(
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
                        'What is Your Trade worth',
                        'We Want Your Car',
                        'Trade Offer',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC7500,#CC7500)',
                        'border-color' => '#cc7500',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '#00a300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '#094e83',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button[onclick*=FULL],a[onclick*=FULL]',
            'css-class' => 'button[onclick*=FULL],a[onclick*=FULL]',
            'css-hover' => 'button[onclick*=FULL],a[onclick*=FULL]:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'button[onclick*=FULL],a[onclick*=FULL] span',
                    'values' => array(
                        'No Hassle Financing',
                        'Special Finance Offers!',
                        'Explore Payments',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC7500,#CC7500)',
                        'border-color' => '#cc7500',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '#00a300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '#094e83',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[onclick*=BookATestDrive] span',
            'css-class' => 'a[onclick*=BookATestDrive]',
            'css-hover' => 'a[onclick*=BookATestDrive]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[onclick*=BookATestDrive] span',
                    'values' => array(
                        'Test drive',
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC7500,#CC7500)',
                        'border-color' => '#cc7500',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '#00a300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '#094e83',
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