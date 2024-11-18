<?php

global $CronConfigs;

$CronConfigs["performancehondautah"] = array(
    'password' => 'performancehondautah',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '588-065-7546',
    'max_cost' => 4750,
    'bing_account_id' => 156002888,
    'cost_distribution' => array(
        'adwords' => 4750,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
    ),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "banner" => array(
        "template" => "performancehondautah",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info.",
			"fb_lookalike_description" => "Check out this [year] [make] [model] today. Click for more information.",
			"fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your info. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner"
        ),
    ),
    'fb_config' => [
        'monthly_budget' => 200,
        'account_id' => '1280778765293417',
        'page_id' => '145335552167484',
        'pixel_id' => '1819386634948581',
        'dataset' => '1907949159531410',
        'form_id' => '',
        'action_types' => ['click'],
        'plain' => false,
        'include_stock' => false,
        'polk_data' => true,
        'targeting' => [
            'desktop' => [
                "age_max" => 65,
                "age_min" => 18,
                "geo_locations" => [
                    "regions" => [
                            [
                            "key" => 3887,
                            "name" => 'Utah',
                            "country" => 'US'
                        ]
                    ],
                    "location_types" => ['home']
                ],
                "publisher_platforms" => ['facebook'],
                "facebook_positions" => ['feed'],
                "device_platforms" => ['desktop']
            ],
            'mobile' => [
                "age_max" => 65,
                "age_min" => 18,
                "geo_locations" => [
                    "regions" => [
                            [
                            "key" => 3887,
                            "name" => 'Utah',
                            "country" => 'US'
                        ]
                    ],
                    "location_types" => ['home']
                ],
                "publisher_platforms" => ['facebook'],
                "facebook_positions" => ['feed'],
                "device_platforms" => ['mobile']
            ]
        ]
    ],
        /*   'lead_to'       => ['leads@performancehondabountiful.net'],
          'form_live'     => true,
          'buttons_live'  => true,
          'buttons'       => [
          'request-a-quote'  => [
          'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => 'a.btn.btn-default.eprice.dialog.button,li[data-click-to-call="Call"] .btn.btn-success',
          'css-class' => 'a.btn.btn-default.eprice.dialog.button,li[data-click-to-call="Call"] .btn.btn-success',
          'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover,li[data-click-to-call="Call"] .btn.btn-success:hover',
          'button_action' => ['form','e-price'],
          'sizes'     => [
          '100'   => [
          //'font-size' => '1.4rem'
          ]
          ],
          'texts'     => [
          'request-a-quote'  => [
          'target'    => 'a.btn.btn-default.eprice.dialog.button,li[data-click-to-call="Call"] .btn.btn-success',
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
          'background'       => 'none',
          'background-color' => '#f06b20',
          'border-color'     => '#f06b20',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background'       => 'none',
          'background-color' => '#cf540e',
          'border-color'     => '#cf540e',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'red'  => [
          'normal'    => [
          'background'       => 'none',
          'background-color' => '#e01212',
          'border-color'     => '#e01212',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background'       => 'none',
          'background-color' => '#c60c0d',
          'border-color'     => '#c60c0d',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'green'  => [
          'normal'    => [
          'background'       => 'none',
          'background-color' => '#54b740',
          'border-color'     => '#54b740',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background'       => 'none',
          'background-color' => '#359d22',
          'border-color'     => '#359d22',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'blue'  => [
          'normal'    => [
          'background'       => 'none',
          'background-color' => '#1ca0d1',
          'border-color'     => '#1ca0d1',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background'       => 'none',
          'background-color' => '#188bb7',
          'border-color'     => '#188bb7',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ]
          ]
          ],
          'test-drive'  => [
          'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => 'a[href*=schedule-form]',
          'css-class' => 'a[href*="schedule-form"]',
          'css-hover' => 'a[href*="schedule-form"]:hover',
          'button_action' => ['form','test-drive'],
          'sizes'     => [
          '100'   => [

          ]
          ],
          'texts'     => [
          'financing'  => [
          'target'    => 'a[href*="schedule-form"]',
          'values'    => [
          ' Schedule a Test Drive',
          'Test Drive',
          'Request Test Drive',

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
          ],
          'trade-in'  => [
          'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => 'a[href*=cash-offer]',
          'css-class' => 'a[href*=cash-offer]',
          'css-hover' => 'a[href*=cash-offer]:hover',
          'button_action' => ['form','trade-in'],
          'sizes'     => [
          '100'   => [

          ]
          ],
          'texts'     => [
          'trade-in'  => [
          'target'    => 'a[href*=cash-offer]',
          'values'    => [
          'Appraise my trade in',
          'Value your trade',
          'What\'s your trade worth?',
          'We want your car'

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
          ],
          'financing'  => [
          'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => 'a[href*=get-approved]',
          'css-class' => 'a[href*=get-approved]',
          'css-hover' => 'a[href*=get-approved]:hover',
          'button_action' => ['form','finance'],
          'sizes'     => [
          '100'   => [

          ]
          ],
          'texts'     => [
          'financing'  => [
          'target'    => 'a[href*=get-approved]',
          'values'    => [
          'Apply for Financing',
          'No hassle financing',
          'Financing Available',
          'Get Financed Today',
          //'Special Finance Offers',
          'Explore Payments'

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
          ],
          'request-information'  => [
          'url-match' => '/\/.*(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => 'a[data-href*=vehiclelead-form]',
          'css-class' => 'a[data-href*=vehiclelead-form]',
          'css-hover' => 'a[data-href*=vehiclelead-form]:hover',
          'sizes'     => [
          '100'   => [

          ]
          ],
          'texts'     => [
          'request-information'  => [
          'target'    => 'a[data-href*=vehiclelead-form]',
          'values'    => [
          'Contact Us',
          'More Information',
          'Get More Information',
          'Get More Details',

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
          ],
          'Listing request-a-quote'  => [
          'url-match' => '/\/(?:new|used|certified)-inventory\//i',
          'target'    => null,        //Don't move button
          'locations' => [
          'default'   => null,    //Don't need to change location
          ],
          'action-target' => '.has-eprice .dialog.epriceLink',
          'css-class' => '.has-eprice .dialog.epriceLink',
          'css-hover' => '.has-eprice .dialog.epriceLink:hover',
          'sizes'     => [
          '100'   => [

          ]
          ],
          'texts'     => [
          'request-a-quote'  => [
          'target'    => '.has-eprice .dialog.epriceLink',
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
          'You are Eligible  for Special Pricing',
          'Book Test Drive',
          'Special Pricing!',
          'Get More Information',
          'Ask a Question',
          'Inquire Now',
          'Get Active Market Price',
          'Get Market Price',
          'Market Pricing',
          'Drive-Away Price'
          ]
          ]
          ],
          'styles'    => [
          'orange'  => [
          'normal'    => [
          'background' => '#f06b20',
          'border-color'     => '#f06b20',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background' => '#cf540e',
          'border-color'     => '#cf540e',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'red'  => [
          'normal'    => [
          'background' => '#e01212',
          'border-color'     => '#e01212',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background' => '#c60c0d',
          'border-color'     => '#c60c0d',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'green'  => [
          'normal'    => [
          'background' => '#54b740',
          'border-color'     => '#54b740',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background' => '#359d22',
          'border-color'     => '#359d22',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ],
          'blue'  => [
          'normal'    => [
          'background' => '#1ca0d1',
          'border-color'     => '#1ca0d1',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ],
          'hover'     => [
          'background' => '#188bb7',
          'border-color'     => '#188bb7',
          'color'=> '#fff',
          'display'=> 'block',
          'float'=> 'none',
          'font-family'=> 'Raleway, arial, sans-serif',
          'font-size'=> '14px',
          'font-weight'=> '700',
          'line-height'=> '17px',
          'margin'=> '30px 0 0',
          'padding'=> '9px 10px',
          'position'=> 'relative',
          'text-align'=> 'center',
          'text-decoration'=> 'none',
          ]
          ]
          ]
          ],
          ] */
);
