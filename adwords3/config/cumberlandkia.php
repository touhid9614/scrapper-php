<?php

global $CronConfigs;
$CronConfigs["cumberlandkia"] = array(
    "name" => " cumberlandkia",
    "email" => "regan@smedia.ca",
    "password" => " cumberlandkia",
    "log" => true,
	"banner" => array(
        "template" => "cumberlandkia",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
    'buttons_live' => true,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.vdp-vehicle-pricing-toolbar > center >a',
            'css-class' => 'div.vdp-vehicle-pricing-toolbar > center >a',
            'css-hover' => 'div.vdp-vehicle-pricing-toolbar > center >a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.vdp-vehicle-pricing-toolbar > center >a',
                    'values' => array(
                        'Get Availability',
                        'Ask For Availability',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
            ),
        ],
        'Listing request-information' => [
            'url-match' => '/\\/inventory\\?/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(1) a',
            'css-class' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(1) a',
            'css-hover' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(1) a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(1) a',
                    'values' => array(
                        'Get Availability',
                        'Ask For Availability',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.vdp-vehicle-pricing-toolbar > center >span a',
            'css-class' => 'div.vdp-vehicle-pricing-toolbar > center >span a',
            'css-hover' => 'div.vdp-vehicle-pricing-toolbar > center >span a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'div.vdp-vehicle-pricing-toolbar > center >span a',
                    'values' => array(
                        'Special Finance Offers!',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
            ),
        ],
        'Listing financing' => [
            'url-match' => '/\\/inventory\\?/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(2) span a',
            'css-class' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(2) span a',
            'css-hover' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(2) span a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'div.medium-6.medium-push-6.columns > center:nth-of-type(2) span a',
                    'values' => array(
                        'Special Finance Offers!',
                        'Explore Payments',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
                    ),
                ),
            ),
        ],
    ],
);