<?php

global $CronConfigs;
$CronConfigs["summerlandrv"] = array(
    "name" => "summerlandrv",
    "email" => "regan@smedia.ca",
    "password" => " summerlandrv",
    "log" => true,
    "banner" => array(
        "template" => "summerlandrv",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Come see the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => false,
	'lead_type_new'         => false,
	'lead_type_used'        => false,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#ef1c23", "#ef1c23"),
	'button_color_hover'    => array("#661013", "#661013"),
	'button_color_active'   => array("#661013", "#661013"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "$500 coupon from Summerland RV",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Summerland RV Team",
	'forward_to'            => array("kevin@summerlandrv.com ","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
	
    //The "Get a Quote" will use sMedia form.All other buttons will not use sMedia form.
//    'adf_to' => array(
//        'kevin@summerlandrvcentre.com',
//        'aaron@summerlandrvcentre.com',
//    ),
//    'form_live' => true,
//    'buttons_live' => true,
//    'buttons' => [
//        'request-a-quote' => [
//            'url-match' => '/\\/default.asp\\?page=x(?:Inventory|NewInventory|PreOwnedInventory)Detail/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'li.textbutton.invGetQuote a',
//            'css-class' => 'li.textbutton.invGetQuote a',
//            'css-hover' => 'li.textbutton.invGetQuote a:hover',
//            'button_action' => [
//                'form',
//                'e-price',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'request-a-quote' => [
//                    'target' => 'li.textbutton.invGetQuote a',
//                    'values' => array(
//                        'REQUEST A QUOTE',
//                        'GET E-PRICE',
//                        'GET OUR BEST PRICE',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#F06B20,#F06B20)',
//                        'border-color' => '#f06b20',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#cf540e',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#E01212,#E01212)',
//                        'border-color' => '#e01212',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#c60c0d',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#54B740,#54B740)',
//                        'border-color' => '#54b740',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#359d22',
//                        'color' => '#fff !important',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
//                        'border-color' => '#1ca0d1',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '16px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#188bb7',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//            ),
//        ],
//        'trade-in' => [
//            'url-match' => '/\\/default.asp\\?page=x(?:Inventory|NewInventory|PreOwnedInventory)Detail/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'li.textbutton.invValueTrade a ',
//            'css-class' => 'li.textbutton.invValueTrade a',
//            'css-hover' => 'li.textbutton.invValueTrade a:hover',
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'trade-in' => [
//                    'target' => 'li.textbutton.invValueTrade a',
//                    'values' => array(
//                        'TRADE-IN APPRAISAL',
//                        'WHAT\'S YOUR TRADE WORTH?',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#F06B20,#F06B20)',
//                        'border-color' => '#f06b20',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#cf540e',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#E01212,#E01212)',
//                        'border-color' => '#e01212',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#c60c0d',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#54B740,#54B740)',
//                        'border-color' => '#54b740',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#359d22',
//                        'color' => '#fff !important',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
//                        'border-color' => '#1ca0d1',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '16px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#188bb7',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//            ),
//        ],
//        'financing' => [
//            'url-match' => '/\\/default.asp\\?page=x(?:Inventory|NewInventory|PreOwnedInventory)Detail/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'li.textbutton.invGetFinancing a',
//            'css-class' => 'li.textbutton.invGetFinancing a',
//            'css-hover' => 'li.textbutton.invGetFinancing a:hover',
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'financing' => [
//                    'target' => 'li.textbutton.invGetFinancing a',
//                    'values' => array(
//                        'NO HASSLE FINANCING',
//                        'GET FINANCED TODAY',
//                        'EXPLORE PAYMENTS',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#F06B20,#F06B20)',
//                        'border-color' => '#f06b20',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#cf540e',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#E01212,#E01212)',
//                        'border-color' => '#e01212',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#c60c0d',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#54B740,#54B740)',
//                        'border-color' => '#54b740',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#359d22',
//                        'color' => '#fff !important',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
//                        'border-color' => '#1ca0d1',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '16px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#188bb7',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//            ),
//        ],
//        'request-information' => [
//            'url-match' => '/\\/default.asp\\?page=x(?:Inventory|NewInventory|PreOwnedInventory)Detail/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'li.textbutton.invContactUs a',
//            'css-class' => 'li.textbutton.invContactUs a',
//            'css-hover' => 'li.textbutton.invContactUs a:hover',
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'request-information' => [
//                    'target' => 'li.textbutton.invContactUs a',
//                    'values' => array(
//                        'GET MORE INFO',
//                        'REQUEST MORE INFO',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#F06B20,#F06B20)',
//                        'border-color' => '#f06b20',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#cf540e',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#E01212,#E01212)',
//                        'border-color' => '#e01212',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#c60c0d',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#54B740,#54B740)',
//                        'border-color' => '#54b740',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#359d22',
//                        'color' => '#fff !important',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
//                        'border-color' => '#1ca0d1',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '16px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '#188bb7',
//                        'color' => '#fff',
//                        'display' => 'block',
//                        'padding' => '14px 15px',
//                        'position' => 'relative',
//                        'font-size' => '15px',
//                        'line-height' => '1.42857143',
//                        'text-transform' => 'uppercase',
//                    ),
//                ),
//            ),
//        ],
//    ],
);