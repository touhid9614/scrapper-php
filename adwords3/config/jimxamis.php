<?php

global $CronConfigs;
$CronConfigs["jimxamis"] = array(
    "name" => " jimxamis",
    "email" => "regan@smedia.ca",
    "password" => " jimxamis",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "jimxamis",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#2A8BBE",
            "#2A8BBE",
        ),
        'button_color_hover' => array(
            "#094794",
            "#094794",
        ),
        'button_color_active' => array(
            "#094794",
            "#094794",
        ),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Jim Xamis Ford",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Jim Xamis Ford Team",
        'forward_to' => array(
            "gvanos@jimxamis.com",
            "tomt@jimxamis.com",
            "marshal@smedia.ca",
        ),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
    'lead_to' => array(
        'gvanos@jimxamis.com',
        'tomt@jimxamis.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#getSalePriceEntryFormButton.btn.btn-cta.ePriceBtn',
            'css-class' => '#getSalePriceEntryFormButton.btn.btn-cta.ePriceBtn',
            'css-hover' => '#getSalePriceEntryFormButton.btn.btn-cta.ePriceBtn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '#getSalePriceEntryFormButton.btn.btn-cta.ePriceBtn',
                    'values' => array(
                        'Get Your Best Price Now!',
                        'Click Here for the Best Price Available',
                        'Get The Right Price',
                        'Get Today\'s Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => '#FF6633',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D9562B,#D9562B)',
                        'border-color' => '#D9562B',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E93E3E,#E93E3E)',
                        'border-color' => '#E93E3E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B93131,#B93131)',
                        'border-color' => '#B93131',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094794,#094794)',
                        'border-color' => '#094794',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#07356E,#07356E)',
                        'border-color' => '#07356E',
                    ),
                ),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#2D96CD',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#27769F,#27769F)',
                        'border-color' => '#27769F',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.btn.btn-danger.btn-lg.btn-block.ePriceBtn',
            'css-class' => '.btn.btn-danger.btn-lg.btn-block.ePriceBtn',
            'css-hover' => '.btn.btn-danger.btn-lg.btn-block.ePriceBtn:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => '.btn.btn-danger.btn-lg.btn-block.ePriceBtn',
                    'values' => array(
                        'Get E-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Contact Us Now',
                        'Call Us Now',
                        'Inquire Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => '#FF6633',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D9562B,#D9562B)',
                        'border-color' => '#D9562B',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E93E3E,#E93E3E)',
                        'border-color' => '#E93E3E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B93131,#B93131)',
                        'border-color' => '#B93131',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094794,#094794)',
                        'border-color' => '#094794',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#07356E,#07356E)',
                        'border-color' => '#07356E',
                    ),
                ),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#2D96CD',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#27769F,#27769F)',
                        'border-color' => '#27769F',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href="/testdrive.aspx"].btn.btn-main',
            'css-class' => 'a[href="/testdrive.aspx"].btn.btn-main',
            'css-hover' => 'a[href="/testdrive.aspx"].btn.btn-main:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href="/testdrive.aspx"].btn.btn-main',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => '#FF6633',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D9562B,#D9562B)',
                        'border-color' => '#D9562B',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E93E3E,#E93E3E)',
                        'border-color' => '#E93E3E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B93131,#B93131)',
                        'border-color' => '#B93131',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094794,#094794)',
                        'border-color' => '#094794',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#07356E,#07356E)',
                        'border-color' => '#07356E',
                    ),
                ),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#2D96CD',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#27769F,#27769F)',
                        'border-color' => '#27769F',
                    ),
                ),
            ),
        ],
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[href*="/testdrive.aspx?type=Used"].btn.btn-main',
            'css-class' => '[href*="/testdrive.aspx?type=Used"].btn.btn-main',
            'css-hover' => '[href*="/testdrive.aspx?type=Used"].btn.btn-main:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '[href*="/testdrive.aspx?type=Used"].btn.btn-main',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => '#FF6633',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D9562B,#D9562B)',
                        'border-color' => '#D9562B',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E93E3E,#E93E3E)',
                        'border-color' => '#E93E3E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B93131,#B93131)',
                        'border-color' => '#B93131',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094794,#094794)',
                        'border-color' => '#094794',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#07356E,#07356E)',
                        'border-color' => '#07356E',
                    ),
                ),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D96CD,#2D96CD)',
                        'border-color' => '#2D96CD',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#27769F,#27769F)',
                        'border-color' => '#27769F',
                    ),
                ),
            ),
        ],
    ],
);