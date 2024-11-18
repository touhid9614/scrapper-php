<?php

global $CronConfigs;
$CronConfigs["holidaygm"] = array(
    "name" => " holidaygm",
    "email" => "regan@smedia.ca",
    "password" => " holidaygm",
    "log" => true,
    'adf_to' => array(
        'weblead@holidayautomotive.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'call' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="c2a29eb3-498f-4406-b264-85fe629b3078"]',
            'css-class' => 'a[name="c2a29eb3-498f-4406-b264-85fe629b3078"]',
            'css-hover' => 'a[name="c2a29eb3-498f-4406-b264-85fe629b3078"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'call' => [
                    'target' => 'a[name="c2a29eb3-498f-4406-b264-85fe629b3078"]',
                    'values' => array(
                        'Call Us Today',
                        'Reach Us',
                        'Ask A Question',
                        'Get More Information',
                        'Contact Us',
                        'Contact Us Today',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D6273B,#D6273B)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BB1F21,#BB1F21)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F3BD02,#F3BD02)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#E3AB02,#E3AB02)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7C7E81,#7C7E81)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3E3F,#3D3E3F)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
            'css-class' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
            'css-hover' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
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
                        'background' => 'linear-gradient(#D6273B,#D6273B)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BB1F21,#BB1F21)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F3BD02,#F3BD02)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#E3AB02,#E3AB02)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7C7E81,#7C7E81)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3E3F,#3D3E3F)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="a8a9d9be-32ea-4ec3-9c79-c06c541d7af2"]',
            'css-class' => 'a[name="a8a9d9be-32ea-4ec3-9c79-c06c541d7af2"]',
            'css-hover' => 'a[name="a8a9d9be-32ea-4ec3-9c79-c06c541d7af2"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="a8a9d9be-32ea-4ec3-9c79-c06c541d7af2"]',
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
                        'background' => 'linear-gradient(#D6273B,#D6273B)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BB1F21,#BB1F21)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F3BD02,#F3BD02)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#E3AB02,#E3AB02)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7C7E81,#7C7E81)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3E3F,#3D3E3F)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d"]',
            'css-class' => 'a[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d"]',
            'css-hover' => 'a[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d"]',
                    'values' => array(
                        'Create Your Deal',
                        'Send Your Offer',
                        'Negotiate Price',
                        'Make Your Deal',
                        'Place Your Bid',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D6273B,#D6273B)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BB1F21,#BB1F21)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A61AA,#1A61AA)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F3BD02,#F3BD02)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#E3AB02,#E3AB02)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7C7E81,#7C7E81)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3E3F,#3D3E3F)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);