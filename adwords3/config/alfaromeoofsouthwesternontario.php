<?php

global $CronConfigs;

$CronConfigs["alfaromeoofsouthwesternontario"] = array(
  //'budget'    => 2.0,
  'bid'           => 3.0,
  'password'  => 'alfaromeoofsouthwesternontario',
  'log' => true,
    'bid_modifier'  => array(
        'after'     => 45, //days
        'bid'       => 1.5
    ),
     'max_cost'      => 50,


    "email"         => "regan@smedia.ca",
    'post_code'     => 'N8w 5v9',
  
    "create"     => array(
          "new_search"        => yes,
        "used_search"       => no,
        "new_display"       => yes,
        "used_display"      => no,
        "new_retargeting"   => yes,
        "used_retargeting"  => no,
        "new_marketbuyers"  => no,
        "used_marketbuyers" => no,
		 "new_combined"    => yes,
        "used_combined"   => no
    ),
   
    "new_descs"         => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "used_descs"         => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]"
        )
    ),
    "ymmcount_descs" => array(
         array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
        ),
    ),
    "customer_id"   => "637-451-7779",
    "email"         => "regan@smedia.ca",
    "banner"        => array(
        "template"          => "alfaromeoofsouthwesternontario",
		'fb_description'	=> "Are you still interested in the [year] [make] [model]? Click for more info.",
		'fb_lookalike_description'	=> "Test drive the [year] [make] [model] today.",
			"flash_style"       => "default",
			"hst" => yes,
			"border_color"    => "#282828",
        "styels"            => array(
            "new_display"   => "custom_banner",
            "used_display"  => "custom_banner",
            "new_retargeting"  => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers"   => "custom_banner",
            "used_marketbuyers"  => "custom_banner"
            ),
        "font_color"        => "#ffffff"
        ),
   /* 'adf_to'        => ['_lead.C5183@easydealmail.ca'],
    'form_live'     => false,
    'buttons_live'  => false,
    'buttons'       => [
        'request-a-quote'  => [
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
            'target'    => null,        //Don't move button
            'locations' => [
                'default'   => null,    //Don't need to change location
            ],
            'action-target' => 'a[href *=lead-form]',
            'css-class' => 'a[href *="lead-form"]',
            'css-hover' => 'a[href *="lead-form"]:hover',
            //'button_action' => ['form','e-price'],
            'sizes'     => [
                '100'   => [
                    //'font-size' => '1.4rem'
                ]
            ],
            'texts'     => [
                'request-a-quote'  => [
                    'target'    => 'a[href *=lead-form]',
                    'values'    => [
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing'
                    ]
                ]
            ],
            'styles'    => [
                'orange'  => [
                    'normal'    => [
                        'background' => '#f06b20',
                        'border-color'     => '#f06b20'
                    ],
                    'hover'     => [
                        'background' => '#cf540e',
                        'border-color'     => '#cf540e'
                    ]
                ],
                'red'  => [
                    'normal'    => [
                        'background' => '#e01212',
                        'border-color'     => '#e01212'
                    ],
                    'hover'     => [
                        'background' => '#c60c0d',
                        'border-color'     => '#c60c0d'
                    ]
                ],
                'green'  => [
                    'normal'    => [
                        'background' => '#54b740',
                        'border-color'     => '#54b740'
                    ],
                    'hover'     => [
                        'background' => '#359d22',
                        'border-color'     => '#359d22'
                    ]
                ],
                'blue'  => [
                    'normal'    => [
                        'background' => '#1ca0d1',
                        'border-color'     => '#1ca0d1'
                    ],
                    'hover'     => [
                        'background' => '#188bb7',
                        'border-color'     => '#188bb7'
                    ]
                ]
            ]
        ]
    ]
      */ 
    );

