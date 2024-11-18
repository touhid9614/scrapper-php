<?php

global $CronConfigs;
$CronConfigs["holidayfordusa"] = array(
    "name" => " holidayfordusa",
    "email" => "regan@smedia.ca",
    "password" => " holidayfordusa",
    "log" => true,
  /*  'adf_to' => array(
        'weblead@holidayautomotive.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)-[^\\+]+\\+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a#primaryButtonPageModalButton.btn.ePriceBtn',
            'css-class' => 'a#primaryButtonPageModalButton.btn.ePriceBtn',
            'css-hover' => 'a#primaryButtonPageModalButton.btn.ePriceBtn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a#primaryButtonPageModalButton.btn.ePriceBtn',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'Get Current Market Price',
                        'Get More Details',
                        'Get A Quote',
                        'Inquire Now!',
                        'Get Your Exclusive Price',
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
                'dark-blue' => array(
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
        'payment-calculator' => [
            'url-match' => '/\\/(?:new|used)-[^\\+]+\\+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=paymentcalc].btn.btn-alt2.btn-block',
            'css-class' => 'a[href*=paymentcalc].btn.btn-alt2.btn-block',
            'css-hover' => 'a[href*=paymentcalc].btn.btn-alt2.btn-block:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'payment-calculator' => [
                    'target' => 'a[href*=paymentcalc].btn.btn-alt2.btn-block',
                    'values' => array(
                        'Calculate Your Payments',
                        'Payment Options',
                        'Estimate Payments',
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
                'dark-blue' => array(
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
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)-[^\\+]+\\+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=trade].btn.btn-alt2.btn-block',
            'css-class' => 'a[href*=trade].btn.btn-alt2.btn-block',
            'css-hover' => 'a[href*=trade].btn.btn-alt2.btn-block:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade].btn.btn-alt2.btn-block',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Get Trade-In Value',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                        'Trade Offer',
                        'Trade-In Your Ride',
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
                'dark-blue' => array(
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
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)-[^\\+]+\\+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=testdrive].btn.btn-alt2.btn-block',
            'css-class' => 'a[href*=testdrive].btn.btn-alt2.btn-block',
            'css-hover' => 'a[href*=testdrive].btn.btn-alt2.btn-block:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=testdrive].btn.btn-alt2.btn-block',
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
                'dark-blue' => array(
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
        'financing' => [
            'url-match' => '/\\/(?:new|used)-[^\\+]+\\+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=preapproved].btn.btn-alt2.btn-block',
            'css-class' => 'a[href*=preapproved].btn.btn-alt2.btn-block',
            'css-hover' => 'a[href*=preapproved].btn.btn-alt2.btn-block:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=preapproved].btn.btn-alt2.btn-block',
                    'values' => array(
                        'Financing Options',
                        'Get Your Loan Online',
                        'Apply For Financing',
                        'Special Finance Offers',
                        'Financing Available',
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
                'dark-blue' => array(
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
    ],*/
);