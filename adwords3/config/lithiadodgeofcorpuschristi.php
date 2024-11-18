<?php

global $CronConfigs;

$CronConfigs["lithiadodgeofcorpuschristi"] = array(
  'password'  => 'lithiadodgeofcorpuschristi',
    "email"         => "regan@smedia.ca",
    'log'           => true,

    "banner"        => array(
        "template"          => "lithiadodgeofcorpuschristi",
		"fb_description"	=> "Are you still interested in the [year] [make] [model]? Click below for more info!",
		"flash_style"       => "default",
		"border_color"    => "#282828",
        "font_color"        => "#ffffff"
        ),
/*    'adf_to'        => ['txcordod_leads@lithia.com'],
    'form_live'     => true,
    'buttons_live'  => true,
    'buttons'       => [
        'request-a-quote'  => [
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
            'target'    => null,        //Don't move button
            'locations' => [
                'default'   => null,    //Don't need to change location
            ],
            'action-target' => 'a.btn.eprice.dialog.button',
            'css-class' => 'a.btn.eprice.dialog.button',
            'css-hover' => 'a.btn.eprice.dialog.button:hover',
            'button_action' => ['form','e-price'],
            'sizes'     => [
                '100'   => [
                    //'font-size' => '1.4rem'
                ]
            ],
            'texts'     => [
                'request-a-quote'  => [
                    'target'    => 'a.btn.eprice.dialog.button',
                    'values'    => [
                        'Get Deal ',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Request Quote',
                        "Inquire Now",
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
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
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
                        'Get More Information',
                        'Ask A Question',
                        'More Info',
                        'Get More Info',
                        'Contact Us',

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
            'action-target' => 'a[href*=kbb].btn-primary',
            'css-class' => 'a[href*=kbb].btn-primary',
            'css-hover' => 'a[href*=kbb].btn-primary:hover',
            'button_action' => ['form','trade-in'],
            'sizes'     => [
                '100'   => [
                    
                ]
            ],
            'texts'     => [
                'trade-in'  => [
                    'target'    => 'a[href*=kbb].btn-primary',
                    'values'    => [
                       'Get Trade-In Value',
                        'Trade Offer',
                        'What is Your Trade Worth?',
                        'We Want Your Car',
                        "We'll Buy Your Car",
                        "Trade Appraisal",
                    ]
                ]
            ],
            'styles'    => [
                'orange'  => [
                    'normal'    => [
                        'background' => '#f06b20',
                        'border-color'     => '#f06b20',
                        'text-decoration'=> 'none',
                    ],
                    'hover'     => [
                        'background' => '#cf540e',
                        'border-color'     => '#cf540e',
                        'text-decoration'=> 'none',
                    ]
                ],
                'red'  => [
                    'normal'    => [
                        'background' => '#e01212',
                        'border-color'     => '#e01212',
                        'text-decoration'=> 'none',
                    ],
                    'hover'     => [
                        'background' => '#c60c0d',
                        'border-color'     => '#c60c0d',
                        'text-decoration'=> 'none',
                    ]
                ],
                'green'  => [
                    'normal'    => [
                        'background' => '#54b740',
                        'border-color'     => '#54b740',
                        'text-decoration'=> 'none',
                    ],
                    'hover'     => [
                        'background' => '#359d22',
                        'border-color'     => '#359d22',
                        'text-decoration'=> 'none',
                    ]
                ],
                'blue'  => [
                    'normal'    => [
                        'background' => '#1ca0d1',
                        'border-color'     => '#1ca0d1',
                        'text-decoration'=> 'none',
                    ],
                    'hover'     => [
                        'background' => '#188bb7',
                        'border-color'     => '#188bb7',
                        'text-decoration'=> 'none',
                    ]
                ]
            ]
        ]
    ]   */
    );
