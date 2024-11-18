<?php

global $CronConfigs;
$CronConfigs["vwmidtowntoronto"] = array(
    "name" => " vwmidtowntoronto",
    "email" => "regan@smedia.ca",
    "password" => " vwmidtowntoronto",
    "log" => true,
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.block-cta__ctas-instance a[href *=financing-request]',
            'css-class' => '.block-cta__ctas-instance a[href *=financing-request]',
            'css-hover' => '.block-cta__ctas-instance a[href *=financing-request]:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '.block-cta__ctas-instance a[href *=financing-request]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#184d7f',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#b23850',
                        'color' => '#b23850',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B23850,#B23850)',
                        'color' => '#ffffff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F05F40,#F05F40)',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#00887a ',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00887A,#00887A)',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.block-cta__ctas-instance a[href *=exchange-car]',
            'css-class' => '.block-cta__ctas-instance a[href *=exchange-car]',
            'css-hover' => '.block-cta__ctas-instance a[href *=exchange-car]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '.block-cta__ctas-instance a[href *=exchange-car]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#184d7f',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#b23850',
                        'color' => '#b23850',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B23850,#B23850)',
                        'color' => '#ffffff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F05F40,#F05F40)',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#00887a ',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00887A,#00887A)',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.block-cta__ctas-instance a[href *=road-test]',
            'css-class' => '.block-cta__ctas-instance a[href *=road-test]',
            'css-hover' => '.block-cta__ctas-instance a[href *=road-test]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '.block-cta__ctas-instance a[href *=road-test]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#184d7f',
                        'color' => '#00638c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => '#ffffff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#b23850',
                        'color' => '#b23850',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B23850,#B23850)',
                        'color' => '#ffffff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#f05f40',
                        'color' => '#f05f40',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F05F40,#F05F40)',
                        'color' => '#ffffff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#00887a ',
                        'color' => '#00887a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00887A,#00887A)',
                        'color' => '#ffffff',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/en\\/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.inventory-details__header-cta a',
            'css-class' => '.inventory-details__header-cta a',
            'css-hover' => '.inventory-details__header-cta a:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.inventory-details__header-cta a div',
                    'values' => array(
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important;"  >Get a Quote</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important; " >Get ePrice</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important;" >Get Internet Price</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important; " >Get Our Best Price</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important;" >Get Sale Price</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important;" >Special Pricing</span>',
                        '<span onMouseOver="this.style.color=\'#FFF\'" onMouseOut="this.style.color=\'#00638c\'"  style="color:#00638c; padding: 20px 67px !important;" >Inquire Now</span>',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0DB2F4,#0DB2F4)',
                        'border-color' => '#184d7f',
                        'color' => 'transparent',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => 'transparent',
                        'height' => '50px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0DB2F4,#0DB2F4)',
                        'border-color' => '#184d7f',
                        'color' => 'transparent',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => 'transparent',
                        'height' => '50px',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0DB2F4,#0DB2F4)',
                        'border-color' => '#184d7f',
                        'color' => 'transparent',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => 'transparent',
                        'height' => '40px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0DB2F4,#0DB2F4)',
                        'border-color' => '#184d7f',
                        'color' => 'transparent',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00638C,#00638C)',
                        'color' => 'transparent',
                        'height' => '50px',
                    ),
                ),
            ),
        ],
    ],
);