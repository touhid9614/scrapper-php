<?php

global $CronConfigs;
$CronConfigs["enslexus"] = array(
    "name" => " enslexus",
    "email" => "regan@smedia.ca",
    "password" => "enslexus",
    "log" => true,
    "banner" => array(
        "template" => "enslexus",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more information.",
        'fb_lookalike_description' => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    //    'adf_to' => array(
    //        '',
    //    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.button-group a',
            'css-class' => 'div.button-group a',
            'css-hover' => 'div.button-group a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.button-group a',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'Get Active Market Price',
                        'E-Price',
                        'Internet Price',
                        'Get Special Price',
                        'Get Your Exclusive Price',
                        'Get A Quote',
),
],
],
            'styles' => array(
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#767676,#767676)',
                        'border-color' => '767676',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C71229,#C71229)',
                        'border-color' => 'C71229',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C71229,#C71229)',
                        'border-color' => 'C71229',
                        'color' => '#fff',
),
),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
),
],
],
);