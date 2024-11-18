<?php

global $CronConfigs;
$CronConfigs["lexusonthepark"] = array(
    'password' => 'lexusonthepark',
    "email" => "regan@smedia.ca",
    'log' => false,
    'tag_debug' => false,
    "banner" => array(
        "template" => "lexusonthepark",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
  /*  'adf_to' => array(
        'leads@toyotanorthwestedmonton.motosnap.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/.*(?:new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=eprice-form].btn.ddc-btn',
            'css-class' => 'a[href*="eprice-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="eprice-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form].btn.ddc-btn',
                    'values' => array(
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Inquire Now!',
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Lease or Finance Quote',
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Get Finance or Lease Quote',
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Finance or Lease Quote',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
        'Used request-a-quote' => [
            'url-match' => '/\\/.*(?:used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=eprice-form].btn.ddc-btn',
            'css-class' => 'a[href*="eprice-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="eprice-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form].btn.ddc-btn',
                    'values' => array(
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Finance Quote',
                        '<i class=\\"ddc-icon ddc-icon-banknote\\"></i>Request Finance Quote',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=lead-form].btn.ddc-btn',
            'css-class' => 'a[href*="lead-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="lead-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a[href*=lead-form].btn.ddc-btn',
                    'values' => array(
                        'More Information',
                        'Get More Information',
                        'Get More Details',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=trade].btn.ddc-btn',
            'css-class' => 'a[href*=trade].btn.ddc-btn',
            'css-hover' => 'a[href*=trade].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade].btn.ddc-btn',
                    'values' => array(
                        'WHAT\'S YOUR TRADE WORTH?',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=financing].btn.ddc-btn.btn-default',
            'css-class' => 'a[href*="financing"].btn.ddc-btn.btn-default',
            'css-hover' => 'a[href*="financing"].btn.ddc-btn.btn-default:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing].btn.ddc-btn.btn-default',
                    'values' => array(
                        'Explore Payments',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=schedule-form].btn.ddc-btn',
            'css-class' => 'a[href*="schedule-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="schedule-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*="schedule-form"].btn.ddc-btn',
                    'values' => array(
                        'TEST RIDE',
                        'Book My Test Drive',
                        'SCHEDULE MY TEST DRIVE',
                    ),
                ],
            ],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '#111',
                    ),
                ),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#b9b099',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#aba085',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#494949,#494949)',
                        'border-color' => '#494949',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#383838,#383838)',
                        'border-color' => '#383838',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#244D6C,#244D6C)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#52758B,#52758B)',
                        'border-color' => '#52758b',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0080B5,#0080B5)',
                        'border-color' => '#244d6c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2386B0,#2386B0)',
                        'border-color' => '#52758b',
                    ),
                ),
            ),
        ],
    ],*/
);