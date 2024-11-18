<?php

global $CronConfigs;
$CronConfigs["robgreenhyundai"] = array(
    "name" => " robgreenhyundai",
    "email" => "regan@smedia.ca",
    "password" => "robgreenhyundai",
    "log" => true,
    "banner" => array(
        "template" => "robgreenhyundai",
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
        ////New Get No Brainer Price///
        'request-a-quote' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
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
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        ///New Reserve It Now///
        'reserve-it-now' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
            'css-class' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
            'css-hover' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'reserve-it-now' => [
                    'target' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
                    'values' => array(
                        'Click Here To Reserve Now',
                        'Reserve Online Now',
                        'Make A Reservation',
                        'Reserve Vehicle Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        ///New Pre Qualify For Credit///
        'financing' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3):hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
                    'values' => array(
                        'No hassle financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Special Finance Offers!',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///New apply for credit///
        'apply-for-credit' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4):hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'apply-for-credit' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Special FInance Offers',
                        'Apply for Financing',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///value a trade///
        'trade-in' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1):hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///Test Drive///
        'test-drive' => [
            'url-match' => '/\\/new-inventory\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn[href *="test-drive"]',
            'css-class' => 'a.btn[href *="test-drive"]',
            'css-hover' => 'a.btn[href *="test-drive"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.btn[href *="test-drive"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
            ),
        ],
        ///USED///
        ////Used Get No Brainer Price///
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
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
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        ///USED Reserve It Now///
        'reserve-it-now' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
            'css-class' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
            'css-hover' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'reserve-it-now' => [
                    'target' => 'a.btn.btn-primary.btn-lg.btn-block.calculate-dealertrack',
                    'values' => array(
                        'Click Here To Reserve Now',
                        'Reserve Online Now',
                        'Make A Reservation',
                        'Reserve Vehicle Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                    ),
                ),
            ),
        ],
        ///USED Pre Qualify For Credit///
        'financing' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3):hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(3)',
                    'values' => array(
                        'No hassle financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Special Finance Offers!',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///USED  apply for credit///
        'apply-for-credit' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4):hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'apply-for-credit' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(4)',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Special FInance Offers',
                        'Apply for Financing',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///Used value a trade///
        'trade-in' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
            'css-class' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
            'css-hover' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1):hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'ul.list-unstyled.nav-stacked.tools-list li:nth-of-type(1)',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '9px 10px',
                    ),
                ),
            ),
        ],
        ///Used Test Drive///
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn[href *="test-drive"]',
            'css-class' => 'a.btn[href *="test-drive"]',
            'css-hover' => 'a.btn[href *="test-drive"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.btn[href *="test-drive"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#C47C18',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#A96B14',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#C21116',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#9D0A0E',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#54B740',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#359D22',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E1AD00,#E1AD00)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D1A102,#D1A102)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
                'purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '#184D7F',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '#123E65',
                        'color' => '#FFFFFF',
                        'padding' => '15px 10px',
                        'font-size' => '16px',
                    ),
                ),
            ),
        ],
    ],
);