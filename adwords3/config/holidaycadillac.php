<?php

global $CronConfigs;
$CronConfigs["holidaycadillac"] = array(
    "name" => " holidaycadillac",
    "email" => "regan@smedia.ca",
    "password" => " holidaycadillac",
    "log" => true,
  /*  'adf_to' => '',
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        ////Schedule Test Drive///
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
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
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '#97140C',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CBAA4D,#CBAA4D)',
                        'border-color' => '#CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00426B,#00426B)',
                        'border-color' => '#00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#71747D,#71747D)',
                        'border-color' => '#71747D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        //Price Watch///
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="e89336ad-815d-4730-8d14-7968c9c44cd0"]',
            'css-class' => 'a[name="e89336ad-815d-4730-8d14-7968c9c44cd0"]',
            'css-hover' => 'a[name="e89336ad-815d-4730-8d14-7968c9c44cd0"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'price-watch' => [
                    'target' => 'a[name="e89336ad-815d-4730-8d14-7968c9c44cd0"]',
                    'values' => array(
                        'Watch Price',
                        'Follow Price',
                        'Track Price',
                        'Get Price Alerts',
                        'Get Price Updates',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '#97140C',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CBAA4D,#CBAA4D)',
                        'border-color' => '#CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00426B,#00426B)',
                        'border-color' => '#00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#71747D,#71747D)',
                        'border-color' => '#71747D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        //        ///Accessories//
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
            'css-class' => '[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
            'css-hover' => '[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
                    'values' => array(
                        'Local Pricing',
                        'Best Price',
                        'Get Current Market Price',
                        'Get A Quote',
                        'Get Your Exclusive Price',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '#97140C',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CBAA4D,#CBAA4D)',
                        'border-color' => '#CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00426B,#00426B)',
                        'border-color' => '#00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#71747D,#71747D)',
                        'border-color' => '#71747D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        ///Get A Lease Quote//
        'lease' => [
            'url-match' => '/\\/VehicleDetails\\/new-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
            'css-class' => 'a[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
            'css-hover' => 'a[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'lease' => [
                    'target' => 'a[name="2b2272ea-803c-437d-8ee5-6d9cf6b8ab61"]',
                    'values' => array(
                        'Lease Quote',
                        'Request Lease Quote',
                        'Get Best Lease Deal',
                        'Lease Payments',
                        'Lease Offer',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '#97140C',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CBAA4D,#CBAA4D)',
                        'border-color' => '#CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00426B,#00426B)',
                        'border-color' => '#00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#71747D,#71747D)',
                        'border-color' => '#71747D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1E1C1D,#1E1C1D)',
                        'border-color' => '#1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
    ],*/
);