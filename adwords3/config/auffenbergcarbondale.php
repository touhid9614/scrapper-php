<?php

global $CronConfigs;

$CronConfigs["auffenbergcarbondale"] = array(
  'password'  => 'auffenbergcarbondale',
    "email"         => "regan@smedia.ca",
    'log'           => true, 
        'combined_feed_mode' => true,
/*
	"lead"  => array(
        'live'                  => false,
        'lead_type_'            => false,
        'lead_type_new'         => false,
        'lead_type_used'        => false,
        'bg_color'              => "#efefef",
        'text_color'            => "#404450",
        'border_color'          => "#e5e5e5",
        'button_color'          => array("#003399", "#003399"),
        'button_color_hover'    => array("#0033cc", "#0033cc"),
        'button_color_active'   => array("#e1a504", "#e1a504"),
        'button_text_color'     => "#ffffff",
        'response_email_subject'=> "Get $200 off with this offer from Auffenberg of Carbondale",
        'response_email'        => "Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Auffenberg of Carbondale",
        'forward_to'            => array("avanvooren@chrisauffenberg.com", "auffenbergofcarbondale2032@adfleads.com", "marshal@smedia.ca"),
        'respond_from'          => "offers@mail.smedia.ca",
        'forward_from'          => "offers@mail.smedia.ca",
        'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    ),
*/
    "banner"        => array(
        "template"          => "auffenbergcarbondale",
		'fb_description'	=> "Are you still interested in the [year] [make] [model]? Click for more info.",
		'fb_lookalike_description'	=> "Test drive the [year] [make] [model] today.",
			"flash_style"       => "default",
			"border_color"    => "#282828",
        "font_color"        => "#ffffff"
        ),
//    'form_live'     => false,
//    'buttons_live'  => false,
//    'buttons'       => [
//        'request-a-quote'  => [
//            'url-match' => '/\/VehicleDetails\/(?:new|used|certified)-/i',
//            'target'    => null,        //Don't move button
//            'locations' => [
//                'default'   => null,    //Don't need to change location
//            ],
//            'action-target' => 'a[name=826ed42f-1e2d-4e5f-8663-2a25ab94bbd4]',
//            'css-class' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
//            'css-hover' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
//         // 'button_action' => ['form','e-price'],
//            'sizes'     => [
//                '100'   => [
//                    'font-size' => '1.4rem'
//                ]
//            ],
//            'texts'     => [
//                'request-a-quote'  => [
//                    'target'    => 'a[name=826ed42f-1e2d-4e5f-8663-2a25ab94bbd4]',
//                    'values'    => [
//                        'Request A Quote',
//                        'Get E Price Now!',
//                        'Internet Price',
//                        'Get your Price!',
//                        'E- Price',
//                        'Get Internet Price Now!',
//                        'Contact Us.',
//                        'Get Our Best Price',
//                        'Best Price',
//                        'Contact Us',
//                        'Contact Store',
//                        'Local Pricing',
//                        'Special Pricing!',
//                        'Get More Information',
//                        'Ask a Question',
//                        'Inquire Now',
//                        'Get Active Market Price',
//                        'Get Market Price',
//                        'Market Pricing'
//                    ]
//                ]
//            ],
//            'styles'    => [
//                'orange'  => [
//                    'normal'    => [
//                        'background' => '#f06b20',
//                        'border-color'     => '#f06b20'
//                    ],
//                    'hover'     => [
//                        'background' => '#cf540e',
//                        'border-color'     => '#cf540e'
//                    ]
//                ],
//                'red'  => [
//                    'normal'    => [
//                        'background' => '#e01212',
//                        'border-color'     => '#e01212'
//                    ],
//                    'hover'     => [
//                        'background' => '#c60c0d',
//                        'border-color'     => '#c60c0d'
//                    ]
//                ],
//                'green'  => [
//                    'normal'    => [
//                        'background' => '#54b740',
//                        'border-color'     => '#54b740'
//                    ],
//                    'hover'     => [
//                        'background' => '#359d22',
//                        'border-color'     => '#359d22'
//                    ]
//                ],
//                'blue'  => [
//                    'normal'    => [
//                        'background' => '#1ca0d1',
//                        'border-color'     => '#1ca0d1'
//                    ],
//                    'hover'     => [
//                        'background' => '#188bb7',
//                        'border-color'     => '#188bb7'
//                    ]
//                ]
//            ]
//        ]
//    ]
       
    );

