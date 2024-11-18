<?php
global $CronConfigs;
 $CronConfigs["merrittislandjaguar"] = array( 
	"name"  =>" merrittislandjaguar",
	"email" => "regan@smedia.ca",
	"password" =>" merrittislandjaguar",
	"log" => true ,
	 'adf_to' => array(
        'islandautogroup@newsales.leads.cmdlr.com',
         'shahadathossainece08@gmail.com'
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#getApproved',
            'css-class' => '#getApproved',
            'css-hover' => '#getApproved:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '#getApproved',
                    'values' => array(
                        'Financing Options',
                        'Special Finance Offers!',
                        'Explore Payments',
                        'Get Your Loan Online',
                        'Financing Available',
                        'Apply for Financing',
                        'Get Financed Today',
                    ),
                ],
            ],
            'styles' => array(
                'dark-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4A4F54,#4A4F54)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C121C,#0C121C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button.btn.hash-st_request_a_quote',
            'css-class' => 'button.btn.hash-st_request_a_quote',
            'css-hover' => 'button.btn.hash-st_request_a_quote:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button.btn.hash-st_request_a_quote',
                    'values' => array(
                        'Get Price Updates',
                        'Get Best Price',
                        'Get Exclusive Price',
                        'Get Internet Price',
                        'Get a Quote',
                    ),
                ],
            ],
             'styles' => array(
                'dark-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4A4F54,#4A4F54)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C121C,#0C121C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#tradeIn',
            'css-class' => '#tradeIn',
            'css-hover' => '#tradeIn:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '#tradeIn',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Trade In Offer',
                        'Trade In Your Ride',
                        'Get Trade In Value',
                    ),
                ],
            ],
            'styles' => array(
                'dark-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4A4F54,#4A4F54)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C121C,#0C121C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#scheduleTestDrive',
            'css-class' => '#scheduleTestDrive',
            'css-hover' => '#scheduleTestDrive:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '#scheduleTestDrive',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
                    ),
                ],
            ],
            'styles' => array(
                'dark-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4A4F54,#4A4F54)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C121C,#0C121C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'Used request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[data-url*=eprice-request]',
            'css-class' => '[data-url*=eprice-request]',
            'css-hover' => '[data-url*=eprice-request]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[data-url*=eprice-request]',
                    'values' => array(
                        'Get Price Updates',
                        'Get Best Price',
                        'Get Exclusive Price',
                        'Get Internet Price',
                        'Get a Quote',
                    ),
                ],
            ],
              'styles' => array(
                'dark-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4A4F54,#4A4F54)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C121C,#0C121C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#005A2B,#005A2B)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);