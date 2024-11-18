<?php

global $CronConfigs;
$CronConfigs["kootenaychrysler"] = array(
    "name" => " kootenaychrysler",
    "email" => "regan@smedia.ca",
    "password" => " kootenaychrysler",
    "log" => true,
    "banner" => array(
        "template" => "kootenaychrysler",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#00aeef",
            "#00aeef",
        ),
        'button_color_hover' => array(
            "#02384d",
            "#02384d",
        ),
        'button_color_active' => array(
            "#02384d",
            "#02384d",
        ),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Kootenay Chrysler Dodge Jeep Ram",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Kootenay Chrysler Dodge Jeep Ram Team",
        'forward_to' => array(
            "paul@kootenaychrysler.com",
            "marshal@smedia.ca",
        ),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
    'adf_to' => '',
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=schedule-form]',
            'css-class' => 'a[href*=schedule-form]',
            'css-hover' => 'a[href*=schedule-form]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=schedule-form]',
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
                        'background' => 'linear-gradient(#EC9D0D,#EC9D0D)',
                        'border-color' => '#EC9D0D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EF2D24,#EF2D24)',
                        'border-color' => '#EF2D24',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#303133,#303133)',
                        'border-color' => '#303133',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A468D,#0A468D)',
                        'border-color' => '#0A468D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Get Our Best Price',
                        'Get More Details',
                        'Get Internet Price',
                        'Get E-Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EC9D0D,#EC9D0D)',
                        'border-color' => '#EC9D0D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EF2D24,#EF2D24)',
                        'border-color' => '#EF2D24',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#303133,#303133)',
                        'border-color' => '#303133',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A468D,#0A468D)',
                        'border-color' => '#0A468D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
        'Used request-information' => [
            'url-match' => '/\\/used\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        'Get More Details',
                        'Special Price',
                        'Watch This Price',
                        'Request More Info',
                        'Ask a Question',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EC9D0D,#EC9D0D)',
                        'border-color' => '#EC9D0D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EF2D24,#EF2D24)',
                        'border-color' => '#EF2D24',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#303133,#303133)',
                        'border-color' => '#303133',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A468D,#0A468D)',
                        'border-color' => '#0A468D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
    ],
);