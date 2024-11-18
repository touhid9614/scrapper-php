<?php

global $CronConfigs;
$CronConfigs["cavneub_wolcott"] = array(
    "name" => " cavneub_wolcott",
    "email" => "regan@smedia.ca",
    "password" => " cavneub_wolcott",
    "log" => true,
    "banner" => array(
        "template" => "cavneub_wolcott",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    'adf_to_new' => array(
        'CavNeubChevroletBuick@newsales.leads.cmdlr.com ',
    ),
    'adf_to_used' => array(
        'CavNeubChevroletBuick@usedsales.leads.cmdlr.com ',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        //Create your deal (text_create-deal)//
        'financing' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d" ]',
            'css-class' => '[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d" ]v',
            'css-hover' => '[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d" ]:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '[name="60088fcd-56a0-4cc2-adfa-a15c52ab9f5d" ]',
                    'values' => array(
                        'Customize Your Deal',
                        'Set up your deal',
                        'Make Your Deal',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0069BF,#0069BF)',
                        'border-color' => '#0069BF',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3E5C77,#3E5C77)',
                        'border-color' => '#3E5C77',
                        'color' => '#FFFFFF',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                ),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F46523,#F46523)',
                        'border-color' => '#F46523',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#855452,#855452)',
                        'border-color' => '#855452',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        ///Request a Quote (text_request-a-quote)///
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4" ]',
            'css-class' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4" ]',
            'css-hover' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4" ]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4" ]',
                    'values' => array(
                        'Get Price Updates',
                        'Get Best Price',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Get Special Price Today',
                        'Get Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0069BF,#0069BF)',
                        'border-color' => '#0069BF',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3E5C77,#3E5C77)',
                        'border-color' => '#3E5C77',
                        'color' => '#FFFFFF',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                ),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F46523,#F46523)',
                        'border-color' => '#F46523',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#855452,#855452)',
                        'border-color' => '#855452',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        ///Price Watch (text_price-watch)////
        'request-information' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d" ]',
            'css-class' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d" ]',
            'css-hover' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d" ]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d" ]',
                    'values' => array(
                        'Watch Price',
                        'Price Alerts',
                        'Follow Price',
                        'Track Price',
                        'Get Price Updates',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0069BF,#0069BF)',
                        'border-color' => '#0069BF',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3E5C77,#3E5C77)',
                        'border-color' => '#3E5C77',
                        'color' => '#FFFFFF',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                ),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '#666666',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#121212,#121212)',
                        'border-color' => '#121212',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F46523,#F46523)',
                        'border-color' => '#F46523',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#855452,#855452)',
                        'border-color' => '#855452',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
    ],
);