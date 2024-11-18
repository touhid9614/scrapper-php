<?php

global $CronConfigs;
$CronConfigs["mckinleyvillechevrolet"] = array(
    "name" => " mckinleyvillechevrolet",
    "email" => "regan@smedia.ca",
    "password" => " mckinleyvillechevrolet",
    "log" => true,
    'adf_to' => array(
        '',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Today\'s Quote!',
                        'Get Quote',
                        'Ask for a Quote',
                        'Get A Quote',
                    ),
                ],
            ],
            'styles' => array(
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#59595B,#59595B)',
                        'border-color' => '59595B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#343434,#343434)',
                        'border-color' => '343434',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B8E97,#7B8E97)',
                        'border-color' => '7B8E97',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B6B72,#5B6B72)',
                        'border-color' => '5B6B72',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003C80,#003C80)',
                        'border-color' => '003C80',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#012854,#012854)',
                        'border-color' => '012854',
                    ),
                ),
            ),
        ],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'price-watch' => [
                    'target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
                    'values' => array(
                        'Get Price Alerts',
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
                    ),
                ],
            ],
            'styles' => array(
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#59595B,#59595B)',
                        'border-color' => '59595B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#343434,#343434)',
                        'border-color' => '343434',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B8E97,#7B8E97)',
                        'border-color' => '7B8E97',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B6B72,#5B6B72)',
                        'border-color' => '5B6B72',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003C80,#003C80)',
                        'border-color' => '003C80',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#012854,#012854)',
                        'border-color' => '012854',
                    ),
                ),
            ),
        ],
    ],
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#003471", "#003471"),
	'button_color_hover'    => array("#000000", "#000000"),
	'button_color_active'   => array("#555555", "#555555"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "$250 off coupon from McKinleyville Chevrolet",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>McKinleyville Chevrolet Team",
	'forward_to'            => array("linus@mckchevy.com","syman@mckchevy.com","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);