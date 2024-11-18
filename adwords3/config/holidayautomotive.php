<?php

global $CronConfigs;
$CronConfigs["holidayautomotive"] = array(
    "name" => "holidayautomotive",
    "email" => "regan@smedia.ca",
    "password" => "holidayautomotive",
    "log" => true,
	"banner" => array(
        "template" => "holidayautomotive",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			//"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
			//"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    'adf_to' => array(
        'weblead@holidayautomotive.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|certified|used)-[0-9]{4}-/i',
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
                        'Get Special Pricing',
                        'Get More Details',
                        'Ask for More Info',
                        'Request More Info',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E18,#DA0E18)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C15,#C00C15)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CB60C,#1CB60C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#189C0A,#189C0A)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115D8E,#115D8E)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0E4C74,#0E4C74)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|certified|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'button.btn.popup-overlay.btn-stretch.btn-stretch-100.color-inverted',
            'css-class' => 'button.btn.popup-overlay.btn-stretch.btn-stretch-100.color-inverted',
            'css-hover' => 'button.btn.popup-overlay.btn-stretch.btn-stretch-100.color-inverted:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'button.btn.popup-overlay.btn-stretch.btn-stretch-100.color-inverted',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request a Test Drive',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0E18,#DA0E18)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C00C15,#C00C15)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CB60C,#1CB60C)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#189C0A,#189C0A)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115D8E,#115D8E)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0E4C74,#0E4C74)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);