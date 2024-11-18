<?php

global $CronConfigs;
$CronConfigs["mcmedicinehat"] = array(
    "name" => " mcmedicinehat",
    "email" => "regan@smedia.ca",
    "password" => " mcmedicinehat",
    "log" => true,
    'adf_to' => array(
        'murray.chev.medicine.hat.leads@gmail.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Get Price Updates',
                        'Get Current Market Price',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Confirm Availability',
                        'Get Your Exclusive Price',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#009DE1,#009DE1)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#008BC7,#008BC7)',
                        'border-color' => '#05476D',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F0BA02,#F0BA02)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D6A602,#D6A602)',
                        'border-color' => '#05476D',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B2B2B2,#B2B2B2)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#989898,#989898)',
                        'border-color' => '#05476D',
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
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#009DE1,#009DE1)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#008BC7,#008BC7)',
                        'border-color' => '#05476D',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F0BA02,#F0BA02)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D6A602,#D6A602)',
                        'border-color' => '#05476D',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B2B2B2,#B2B2B2)',
                        'border-color' => '#0B5886',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#989898,#989898)',
                        'border-color' => '#05476D',
                    ),
                ),
            ),
        ],
    ],
);