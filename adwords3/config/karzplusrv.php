<?php

global $CronConfigs;

$CronConfigs["karzplusrv"] = array(
  'password'  => 'karzplusrv',
    "email"         => "regan@smedia.ca",
    'log'           => false,

    "banner"        => array(
        "template"          => "karzplusrv",
		"flash_style"       => "default",
		"border_color"    => "#282828",
        "font_color"        => "#ffffff"
        ),
//    'lead_to'       => ['KARZPLUSESCONDIDO1774@ADFLEADS.COM'],
//    'buttons_live' => false,
//    'buttons' => [
//        'financing' => [
//            'url-match' => '/\/(?:new|certified|used)\/[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-/i',
//            'target' => null, //Don't move button
//            'locations' => [
//                'default' => null, //Don't need to change location
//            ],
//            'action-target' => 'a[href*="pre-qualified"].btn.btn-link',
//            'css-class' => 'a[href*="pre-qualified"].btn.btn-link',
//            'css-hover' => 'a[href*="pre-qualified"].btn.btn-link:hover',
//         // 'button_action' => ['form','finance'],
//            'sizes' => [
//                '100' => [
//                ]
//            ],
//            'texts' => [
//                'financing' => [
//                    'target' => 'a[href*="pre-qualified"].btn.btn-link',
//                    'values' => [
//                        'Get Financed Today',
//                        'Financing Available',
//                        'No Hassle Financing',
//                        'Explore Payments',
//                        'Special Finance Offers!',
//                    ]
//                ]
//            ],
//            'styles'    => [
//                'orange'  => [
//                    'normal'    => [
//                        'background'       => 'none',
//                        'background-color' => '#f06b20',
//                        'border-color'     => '#f06b20',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ],
//                    'hover'     => [
//                        'background'       => 'none',
//                        'background-color' => '#cf540e',
//                        'border-color'     => '#cf540e',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ]
//                ],
//                'red'  => [
//                    'normal'    => [
//                        'background'       => 'none',
//                        'background-color' => '#e01212',
//                        'border-color'     => '#e01212',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ],
//                    'hover'     => [
//                        'background'       => 'none',
//                        'background-color' => '#c60c0d',
//                        'border-color'     => '#c60c0d',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ]
//                ],
//                'green'  => [
//                    'normal'    => [
//                        'background'       => 'none',
//                        'background-color' => '#54b740',
//                        'border-color'     => '#54b740',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ],
//                    'hover'     => [
//                        'background'       => 'none',
//                        'background-color' => '#359d22',
//                        'border-color'     => '#359d22',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ]
//                ],
//                'blue'  => [
//                    'normal'    => [
//                        'background'       => 'none',
//                        'background-color' => '#1ca0d1',
//                        'border-color'     => '#1ca0d1',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ],
//                    'hover'     => [
//                        'background'       => 'none',
//                        'background-color' => '#188bb7',
//                        'border-color'     => '#188bb7',
//                        'color'=> '#fff',
//                        'display'=> 'block',
//                        'float'=> 'none',
//                        'font-family'=> 'Raleway, arial, sans-serif',
//                        'font-size'=> '14px',
//                        'font-weight'=> '700',
//                        'line-height'=> '17px',
//                        'margin'=> '30px 0px 0px 100px',
//                        'padding'=> '9px 10px',
//                        'position'=> 'relative',
//                        'text-align'=> 'center',
//                        'text-decoration'=> 'none',
//                        'max-width'          => '50%', 
//                    ]
//                ]
//            ]
//        ],
//        
//        
//    ]
    );
