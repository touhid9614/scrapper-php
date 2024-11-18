<?php

global $CronConfigs;
$CronConfigs["cumberlandchryslercenter"] = array(
    "name" => " cumberlandchryslercenter",
    "email" => "regan@smedia.ca",
    "password" => " cumberlandchryslercenter",
    'combined_feed_mode' => true,
    "log" => true,
	
	"banner" => array(
        "template" => "cumberlandchryslercenter",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
	
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
            'css-class' => 'a.button.cta-button.block.button-form.fancybox',
            'css-hover' => 'a.button.cta-button.block.button-form.fancybox:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Price',
                        'Get Your Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E77703,#E77703)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#990000,#990000)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2F6624,#2F6624)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        /*   'Listing request-a-quote' => [
                 'url-match' => '/\\/(?:new|used)-vehicles\\//i',
                 'target' => null,
                 //Don't move button
                 'locations' => [
                     'default' => null,
                 ],
                 'action-target' => 'a.fancy.button-form.button.cta-button',
                 'css-class' => 'a.fancy.button-form.button.cta-button',
                 'css-hover' => 'a.fancy.button-form.button.cta-button:hover',
                 'sizes' => [
                     '100' => [],
                 ],
                 'texts' => [
                     'request-a-quote' => [
                         'target' => 'a.fancy.button-form.button.cta-button',
                         'values' => array(
                             'Get ePrice',
                             'Get Internet Price',
                             'Get Our Best Price',
                             'Get Sale Price',
                             'Get Special Price',
                             'Get Your Price',
                         ),
                     ],
                 ],
                 'styles' => array(
                     'orange' => array(
                         'normal' => array(
                             'background' => 'linear-gradient(#E77703,#E77703)',
                             'border-color' => '#f06b20',
                         ),
                         'hover' => array(
                             'background' => 'linear-gradient(#CF540E,#CF540E)',
                             'border-color' => '#cf540e',
                         ),
                     ),
                     'red' => array(
                         'normal' => array(
                             'background' => 'linear-gradient(#990000,#990000)',
                             'border-color' => '#e01212',
                         ),
                         'hover' => array(
                             'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                             'border-color' => '#c60c0d',
                         ),
                     ),
                     'green' => array(
                         'normal' => array(
                             'background' => 'linear-gradient(#2F6624,#2F6624)',
                             'border-color' => '#54b740',
                         ),
                         'hover' => array(
                             'background' => 'linear-gradient(#359D22,#359D22)',
                             'border-color' => '#359d22',
                         ),
                     ),
                     'Cyan' => array(
                         'normal' => array(
                             'background' => 'linear-gradient(#325387,#325387)',
                             'border-color' => '#1ca0d1',
                         ),
                         'hover' => array(
                             'background' => 'linear-gradient(#0093CF,#0093CF)',
                             'border-color' => '#188bb7',
                         ),
                     ),
                 ),
             ],  */
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=trade].button',
            'css-class' => 'a[href*=trade].button',
            'css-hover' => 'a[href*=trade].button:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade].button',
                    'values' => array(
                        'Trade Offer',
                        'Trade Appraisal',
                        'Trade-In Appraisal',
                        'What\'s Your Trade-In Worth',
                        'Trade In Value',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E77703,#E77703)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#990000,#990000)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2F6624,#2F6624)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        /*  'Listing trade-in' => [
                'url-match' => '/\\/(?:new|used)-vehicles\\//i',
                'target' => null,
                //Don't move button
                'locations' => [
                    'default' => null,
                ],
                'action-target' => 'a[href*=trade].button.cta-button.block',
                'css-class' => 'a[href*=trade].button.cta-button.block',
                'css-hover' => 'a[href*=trade].button.cta-button.block:hover',
                'sizes' => [
                    '100' => [],
                ],
                'texts' => [
                    'trade-in' => [
                        'target' => 'a[href*=trade].button.cta-button.block',
                        'values' => array(
                            'Trade Offer',
                            'Trade Appraisal',
                            'Trade-In Appraisal',
                            'What\'s Your Trade-In Worth',
                            'Trade In Value',
                        ),
                    ],
                ],
                'styles' => array(
                    'orange' => array(
                        'normal' => array(
                            'background' => 'linear-gradient(#E77703,#E77703)',
                            'border-color' => '#f06b20',
                        ),
                        'hover' => array(
                            'background' => 'linear-gradient(#CF540E,#CF540E)',
                            'border-color' => '#cf540e',
                        ),
                    ),
                    'red' => array(
                        'normal' => array(
                            'background' => 'linear-gradient(#990000,#990000)',
                            'border-color' => '#e01212',
                        ),
                        'hover' => array(
                            'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                            'border-color' => '#c60c0d',
                        ),
                    ),
                    'green' => array(
                        'normal' => array(
                            'background' => 'linear-gradient(#2F6624,#2F6624)',
                            'border-color' => '#54b740',
                        ),
                        'hover' => array(
                            'background' => 'linear-gradient(#359D22,#359D22)',
                            'border-color' => '#359d22',
                        ),
                    ),
                    'Cyan' => array(
                        'normal' => array(
                            'background' => 'linear-gradient(#325387,#325387)',
                            'border-color' => '#1ca0d1',
                        ),
                        'hover' => array(
                            'background' => 'linear-gradient(#0093CF,#0093CF)',
                            'border-color' => '#188bb7',
                        ),
                    ),
                ),
            ],  */
        'financing' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=get-pre-qualified].button.cta-button.block',
            'css-class' => 'a[href*=get-pre-qualified].button.cta-button.block',
            'css-hover' => 'a[href*=get-pre-qualified].button.cta-button.block:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=get-pre-qualified].button.cta-button.block',
                    'values' => array(
                        'No hassle financing',
                        'Financing Available.',
                        'Get Financed Today',
                        'Special Finance Offers!',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E77703,#E77703)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#990000,#990000)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2F6624,#2F6624)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],
);