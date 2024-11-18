<?php

global $CronConfigs;
$CronConfigs["seabreezeford"] = array(
    "name" => " seabreezeford",
    "email" => "regan@smedia.ca",
    "password" => " seabreezeford",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "seabreezeford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click here for final price!",
        //"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    'adf_to' => 'webleads@sbford.com',
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.price-btn.cst-btn-0.mb-3 a[href*="eprice-form"]',
            'css-class' => 'div.price-btn.cst-btn-0.mb-3 a[href*="eprice-form"]',
            'css-hover' => 'div.price-btn.cst-btn-0.mb-3 a[href*="eprice-form"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.price-btn.cst-btn-0.mb-3 a[href*="eprice-form"]',
                    'values' => array(
                        'Get ePrice',
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0021B,#D0021B)',
                        'border-color' => '#D0021B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A50417,#A50417)',
                        'border-color' => '#A50417',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#DE820E',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B06910,#B06910)',
                        'border-color' => '#B06910',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24B149',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A8235,#1A8235)',
                        'border-color' => '#1A8235',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B477B,#1B477B)',
                        'border-color' => '#1B477B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#12335A,#12335A)',
                        'border-color' => '#12335A',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.price-btn.cst-btn-2.mb-3 a[href*="eprice-form"]',
            'css-class' => 'div.price-btn.cst-btn-2.mb-3 a[href*="eprice-form"]',
            'css-hover' => 'div.price-btn.cst-btn-2.mb-3 a[href*="eprice-form"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.price-btn.cst-btn-2.mb-3 a[href*="eprice-form"]',
                    'values' => array(
                        'Request Your Personalized Quote',
                        'Get Personalized Quote',
                        'Click Here for Personalized Quote',
                    ),
                ],
            ],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24B149',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A8235,#1A8235)',
                        'border-color' => '#1A8235',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#DE820E',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B06910,#B06910)',
                        'border-color' => '#B06910',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0021B,#D0021B)',
                        'border-color' => '#D0021B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A50417,#A50417)',
                        'border-color' => '#A50417',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B477B,#1B477B)',
                        'border-color' => '#1B477B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#12335A,#12335A)',
                        'border-color' => '#12335A',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'ask' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*="lead-form"]',
            'css-class' => 'a[href*="lead-form"]',
            'css-hover' => 'a[href*="lead-form"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a[href*="lead-form"]',
                    'values' => array(
                        'Get More Details',
                        'Ask Question',
                        'More Info',
                        'Learn More',
                        'Ask More Info',
                        'Ask an Expert',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B477B,#1B477B)',
                        'border-color' => '#1B477B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#12335A,#12335A)',
                        'border-color' => '#12335A',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#DE820E',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B06910,#B06910)',
                        'border-color' => '#B06910',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0021B,#D0021B)',
                        'border-color' => '#D0021B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A50417,#A50417)',
                        'border-color' => '#A50417',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24B149',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A8235,#1A8235)',
                        'border-color' => '#1A8235',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*="schedule-form"]',
            'css-class' => 'a[href*="schedule-form"]',
            'css-hover' => 'a[href*="schedule-form"]:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*="schedule-form"]',
                    'values' => array(
                        'Request A Test Drive',
                        'Test Drive Now',
                        'Book Test Drive',
                        'Schedule Your Test Drive',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => '#DE820E',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B06910,#B06910)',
                        'border-color' => '#B06910',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0021B,#D0021B)',
                        'border-color' => '#D0021B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A50417,#A50417)',
                        'border-color' => '#A50417',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24B149',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#1A8235,#1A8235)',
                        'border-color' => '#1A8235',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B477B,#1B477B)',
                        'border-color' => '#1B477B',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#12335A,#12335A)',
                        'border-color' => '#12335A',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);