<?php

global $CronConfigs;
$CronConfigs["ronhodgson"] = array(
    "name" => " ronhodgson",
    "email" => "regan@smedia.ca",
    "password" => " ronhodgson",
    "log" => true,
    'combined_feed_mode' => true,
    "fb_title" => "[year] [make] [model] - [body_style]",
    "banner" => array(
        "template" => "ronhodgson",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
        'button_color' => array("#3495cc", "#3495cc"),
        'button_color_hover' => array("#24688f", "#24688f"),
        'button_color_active' => array("#24688f", "#24688f"),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "$200 off coupon from Ron Hodgson",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Ron Hodgson Team",
        'forward_to' => array("randy@ronhodgson.com", "danny@ronhodgson.com", "gord@ronhodgson.com", "chad@ronhodgson.com", "marshal@smedia.ca"),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
//    'lead_to' => array(
//        'randy@ronhodgson.com',
//        'danny@ronhodgson.com',
//        'gord@ronhodgson.com',
//        'ramid@ronhodgson.com',
//        'james@ronhodgson.com',
//        'nithin@ronhodgson.com',
//        'craig@ronhodgson.com',
//    ),
//    'form_live' => true,
//    'buttons_live' => true,
//    'buttons' => [
//        'request-information' => [
//            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'a[href*=vehiclelead].btn',
//            'css-class' => 'a[href*=vehiclelead].btn',
//            'css-hover' => 'a[href*=vehiclelead].btn:hover',
//            'button_action' => [
//                'form',
//                'e-price',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'request-information' => [
//                    'target' => 'a[href*=vehiclelead].btn',
//                    'values' => array(
//                        'Get More Information',
//                        'Ask For More Info',
//                        'Ask a Question',
//                        'Let Our Experts Help',
//                        'Ask an Expert',
//                        'Learn More',
//                        'More Info',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EF8904,#EF8904)',
//                        'border-color' => '#f06b20',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#cf540e',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#C7424D,#C7424D)',
//                        'border-color' => '#e01212',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#c60c0d',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#6B9840,#6B9840)',
//                        'border-color' => '#54b740',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#359d22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#428FC7,#428FC7)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//                'gray' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#787777,#787777)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//            ),
//        ],
//        'test-drive' => [
//            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'a[href*=schedule].btn',
//            'css-class' => 'a[href*=schedule].btn',
//            'css-hover' => 'a[href*=schedule].btn:hover',
//            'button_action' => [
//                'form',
//                'test-drive',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'test-drive' => [
//                    'target' => 'a[href*=schedule].btn',
//                    'values' => array(
//                        'Book Test Drive',
//                        'Request Test Drive',
//                        'Test Drive',
//                        'Test Drive Today',
//                        'Want to Test Drive?',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EF8904,#EF8904)',
//                        'border-color' => '#f06b20',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#cf540e',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#C7424D,#C7424D)',
//                        'border-color' => '#e01212',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#c60c0d',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#6B9840,#6B9840)',
//                        'border-color' => '#54b740',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#359d22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#428FC7,#428FC7)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//                'gray' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#787777,#787777)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//            ),
//        ],
//        'trade-in' => [
//            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'a[href*=trade-in].btn',
//            'css-class' => 'a[href*=trade-in].btn',
//            'css-hover' => 'a[href*=trade-in].btn:hover',
//            'button_action' => [
//                'form',
//                'trade-in',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'trade-in' => [
//                    'target' => 'a[href*=trade-in].btn',
//                    'values' => array(
//                        'Value Your Trade',
//                        'Get Trade-In Value',
//                        'What\'s Your Trade Worth?',
//                        'Appraise Your Trade',
//                        'Trade-In Appraisal',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EF8904,#EF8904)',
//                        'border-color' => '#f06b20',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#cf540e',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#C7424D,#C7424D)',
//                        'border-color' => '#e01212',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#c60c0d',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#6B9840,#6B9840)',
//                        'border-color' => '#54b740',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#359d22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#428FC7,#428FC7)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//                'gray' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#787777,#787777)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//            ),
//        ],
//        'check-availability' => [
//            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'a[href*=makeanoffer].btn',
//            'css-class' => 'a[href*=makeanoffer].btn',
//            'css-hover' => 'a[href*=makeanoffer].btn:hover',
//            'button_action' => [
//                'form',
//                'e-price',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'trade-in' => [
//                    'target' => 'a[href*=makeanoffer].btn',
//                    'values' => array(
//                        'Check Availability',
//                        'Ask For Availability',
//                        'Get Availability',
//                        'Ask for Availability',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EF8904,#EF8904)',
//                        'border-color' => '#f06b20',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#cf540e',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#C7424D,#C7424D)',
//                        'border-color' => '#e01212',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#c60c0d',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#6B9840,#6B9840)',
//                        'border-color' => '#54b740',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#359d22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#428FC7,#428FC7)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//                'gray' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#787777,#787777)',
//                        'border-color' => '#1ca0d1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#291103,#291103)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//            ),
//        ],
//    ],
);
