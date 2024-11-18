<?php

global $CronConfigs;
$CronConfigs["gandmchevrolet"] = array(
    "name" => " gandmchevrolet",
    "email" => "regan@smedia.ca",
    "password" => " gandmchevrolet",
    "log" => true,
    "banner" => array(
        "template" => "gandmchevrolet",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0979A6',
            '#0979A6',
        ),
        'button_color_hover' => array(
            '#063548',
            '#063548',
        ),
        'button_color_active' => array(
            '#063548',
            '#063548',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 coupon from G&M Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>G&M Chevrolet Team',
        'forward_to' => array(
            'apelletier@gmchev.com',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
    'lead_to' => array(
        'apelletier@gmchev.com',
    ),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Today\'s Quote!',
                        'Get Quote',
                        'Ask for a Quote',
                        'Get A Quote',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0979A6,#0979A6)',
                        'border-color' => '#4C7294',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0D516D,#0D516D)',
                        'border-color' => '#2B4154',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#555555,#555555)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D4D4D,#4D4D4D)',
                        'border-color' => '#000000',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C4982C,#C4982C)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B87F1A,#B87F1A)',
                        'border-color' => '#000000',
                    ),
                ),
                'pink' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD705E,#FD705E)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FF5E64,#FF5E64)',
                        'border-color' => '#000000',
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
            'action-target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Want to Test Drive?',
                        'Request a Test Drive',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0979A6,#0979A6)',
                        'border-color' => '#4C7294',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0D516D,#0D516D)',
                        'border-color' => '#2B4154',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#555555,#555555)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D4D4D,#4D4D4D)',
                        'border-color' => '#000000',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C4982C,#C4982C)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B87F1A,#B87F1A)',
                        'border-color' => '#000000',
                    ),
                ),
                'pink' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD705E,#FD705E)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FF5E64,#FF5E64)',
                        'border-color' => '#000000',
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
            'action-target' => '[name="4f998e13-04d1-4168-9b5d-2f6bda3fe3e8"]',
            'css-class' => '[name="4f998e13-04d1-4168-9b5d-2f6bda3fe3e8"]',
            'css-hover' => '[name="4f998e13-04d1-4168-9b5d-2f6bda3fe3e8"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => '[name="4f998e13-04d1-4168-9b5d-2f6bda3fe3e8"]',
                    'values' => array(
                        'Call Us Today',
                        'Reach Us',
                        'Click Here To Contact Us',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0979A6,#0979A6)',
                        'border-color' => '#4C7294',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0D516D,#0D516D)',
                        'border-color' => '#2B4154',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#555555,#555555)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D4D4D,#4D4D4D)',
                        'border-color' => '#000000',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C4982C,#C4982C)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B87F1A,#B87F1A)',
                        'border-color' => '#000000',
                    ),
                ),
                'pink' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD705E,#FD705E)',
                        'border-color' => '#474747',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FF5E64,#FF5E64)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
    ],
);