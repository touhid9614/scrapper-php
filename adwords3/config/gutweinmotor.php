<?php

global $CronConfigs;
$CronConfigs["gutweinmotor"] = array(
    "name" => " gutweinmotor",
    "email" => "regan@smedia.ca",
    "password" => " gutweinmotor",
    "log" => true,
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0D65BF',
            '#0D65BF',
        ),
        'button_color_hover' => array(
            '#0B55A6',
            '#0B55A6',
        ),
        'button_color_active' => array(
            '#0B55A6',
            '#0B55A6',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Gutwein Motor',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Gutwein Motor Team',
        'forward_to' => array(
            'jonathon@gutweinmtr.com',
            'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    ),
    'lead_to' => array(
        'peter@smedia.ca',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        'Request More Info',
                        'Request Information',
                        'More Information',
                        'More Info',
                        'Learn More',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask Our Expert',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B20000,#B20000)',
                        'border-color' => '#b20000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0066CC,#0066CC)',
                        'border-color' => '#0066cc',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0059B2,#0059B2)',
                        'border-color' => '#0059b2',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00B359,#00B359)',
                        'border-color' => '#00b359',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00994C,#00994C)',
                        'border-color' => '#00994c',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E68A00,#E68A00)',
                        'border-color' => '#e68a00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CC7B00,#CC7B00)',
                        'border-color' => '#cc7b00',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E64B00,#E64B00)',
                        'border-color' => '#e64b00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CC4300,#CC4300)',
                        'border-color' => '#cc4300',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn ',
            'css-class' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn ',
            'css-hover' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn :hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn ',
                    'values' => array(
                        'Price Watch',
                        'Watch Price',
                        'Watch This Price',
                        'Track Price',
                        'Track This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Get Price Updates',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => '#cc0000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B20000,#B20000)',
                        'border-color' => '#b20000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0066CC,#0066CC)',
                        'border-color' => '#0066cc',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0059B2,#0059B2)',
                        'border-color' => '#0059b2',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00B359,#00B359)',
                        'border-color' => '#00b359',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00994C,#00994C)',
                        'border-color' => '#00994c',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E68A00,#E68A00)',
                        'border-color' => '#e68a00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CC7B00,#CC7B00)',
                        'border-color' => '#cc7b00',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E64B00,#E64B00)',
                        'border-color' => '#e64b00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CC4300,#CC4300)',
                        'border-color' => '#cc4300',
                    ),
                ),
            ),
        ],
    ],
);