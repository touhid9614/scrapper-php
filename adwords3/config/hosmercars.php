<?php

global $CronConfigs;
$CronConfigs["hosmercars"] = array(
    "name" => " hosmercars",
    "email" => "regan@smedia.ca",
    "password" => " hosmercars",
    'log' => true,
    "banner" => array(
        "template" => "dealership",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'buttons_live' => false,
    'buttons' => [
        'Listing trade-in' => [
            'url-match' => '/\\/(?:new|used|certified-used)-vehicles/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-xs.searchVehicleValueTradeButton',
            'css-class' => 'a.btn.btn-xs.searchVehicleValueTradeButton',
            'css-hover' => 'a.btn.btn-xs.searchVehicleValueTradeButton:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a.btn.btn-xs.searchVehicleValueTradeButton',
                    'values' => array(
                        'Get e-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Pricing',
                        'Get Today\'s Price',
                        'Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E62530,#E62530)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4171E,#C4171E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
            ),
        ],
        'Listing financing' => [
            'url-match' => '/\\/(?:new|used|certified-used)-vehicles/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-xs.searchVehiclePreApproveButton',
            'css-class' => 'a.btn.btn-xs.searchVehiclePreApproveButton',
            'css-hover' => 'a.btn.btn-xs.searchVehiclePreApproveButton:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a.btn.btn-xs.searchVehiclePreApproveButton',
                    'values' => array(
                        'Get e-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Pricing',
                        'Get Today\'s Price',
                        'Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E62530,#E62530)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4171E,#C4171E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/(?:New|Used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.hidden-xs a[href*=pre-approved-financing].btn.btn.vehicleDetailPreApproval',
            'css-class' => 'div.hidden-xs a[href*=pre-approved-financing].btn.btn.vehicleDetailPreApproval',
            'css-hover' => 'div.hidden-xs a[href*=pre-approved-financing].btn.btn.vehicleDetailPreApproval:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.hidden-xs a[href*=pre-approved-financing].btn.btn.vehicleDetailPreApproval',
                    'values' => array(
                        'Get e-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Pricing',
                        'Get Today\'s Price',
                        'Current Market Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1931C,#F1931C)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#D78319,#D78319)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E62530,#E62530)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4171E,#C4171E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28C618,#28C618)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#23AC14,#23AC14)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1A689A,#1A689A)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#165780,#165780)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'padding' => '5px',
                    ),
                ),
            ),
        ],
    ],
);