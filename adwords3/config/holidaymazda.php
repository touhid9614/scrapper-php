<?php

global $CronConfigs;
$CronConfigs["holidaymazda"] = array(
    "name" => " holidaymazda",
    "email" => "regan@smedia.ca",
    "password" => " holidaymazda",
    "log" => true,
    'adf_to' => array(
        'weblead@holidayautomotive.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button.btn.hash-st_request_a_quote.custom-btn.popup-overlay.btn-stretch.btn-stretch-100',
            'css-class' => 'button.btn.hash-st_request_a_quote.custom-btn.popup-overlay.btn-stretch.btn-stretch-100',
            'css-hover' => 'button.btn.hash-st_request_a_quote.custom-btn.popup-overlay.btn-stretch.btn-stretch-100:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button.btn.hash-st_request_a_quote.custom-btn.popup-overlay.btn-stretch.btn-stretch-100',
                    'values' => array(
                        'Get More Details',
                        'More Info',
                        'Ask for More Info',
                        'Request More Info',
                        'Ask a Question',
                        'Learn More',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E17,#DA0E17)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C14,#C00C14)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2783B3,#2783B3)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#224498,#224498)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#254AA5,#254AA5)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#323232,#323232)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'schedule-appoinment' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button[data-url*=schedule-testdrive]',
            'css-class' => 'button[data-url*=schedule-testdrive]',
            'css-hover' => 'button[data-url*=schedule-testdrive]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'schedule-appoinment' => [
                    'target' => 'button[data-url*=schedule-testdrive]',
                    'values' => array(
                        '<span style="color:#ffffff">Book Test Drive</span>',
                        '<span style="color:#ffffff">Test Drive Now</span>',
                        '<span style="color:#ffffff">Schedule a Test Drive</span>',
                        '<span style="color:#ffffff">Schedule Your Test Drive</span>',
                        '<span style="color:#ffffff">Request A Test Drive</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E17,#DA0E17)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C14,#C00C14)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2783B3,#2783B3)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#224498,#224498)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#254AA5,#254AA5)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#323232,#323232)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff !important',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'reuest-information' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a#epricePopup',
            'css-class' => 'a#epricePopup',
            'css-hover' => 'a#epricePopup:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'reuest-information' => [
                    'target' => 'a#epricePopup',
                    'values' => array(
                        'Get More Details',
                        'More Info',
                        'Ask for More Info',
                        'Request More Info',
                        'Ask a Question',
                        'Learn More',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E17,#DA0E17)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C14,#C00C14)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2783B3,#2783B3)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#224498,#224498)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#254AA5,#254AA5)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#323232,#323232)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a#scheduleTestdrive',
            'css-class' => 'a#scheduleTestdrive',
            'css-hover' => 'a#scheduleTestdrive:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a#scheduleTestdrive',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E17,#DA0E17)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C14,#C00C14)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2783B3,#2783B3)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#224498,#224498)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#254AA5,#254AA5)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#323232,#323232)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
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
            'action-target' => 'a#getApproved',
            'css-class' => 'a#getApproved',
            'css-hover' => 'a#getApproved:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a#getApproved',
                    'values' => array(
                        'Financing Options',
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Get Your Loan Online',
                        'Payment options',
                        'Calculate Lease Payment',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E17,#DA0E17)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C14,#C00C14)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2783B3,#2783B3)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#224498,#224498)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#254AA5,#254AA5)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#323232,#323232)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '10px 10px',
                        'text-align' => 'center',
                    ),
                ),
            ),
        ],
    ],
);