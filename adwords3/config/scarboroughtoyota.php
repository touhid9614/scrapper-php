<?php

global $CronConfigs;
$CronConfigs["scarboroughtoyota"] = array(
    'password' => 'scarboroughtoyota',
    "email" => "regan@smedia.ca",
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "scarboroughtoyota",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'leads@scarboroughtoyotascion.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/.*(?:new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form].btn.ddc-btn',
            'css-class' => 'a[href*="eprice-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="eprice-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form].btn.ddc-btn',
                    'values' => array(
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Price Updates',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Local Pricing',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Best Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Current Market Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Internet Price Now',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get E-Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Price!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Exclusive Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Buy Now!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Buy Now',
                        '<i class="ddc-icon ddc-icon-banknote"></i>YOUR E PRICE',
                        '<i class="ddc-icon ddc-icon-banknote"></i>SPECIAL PRICING!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Special Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Our Best Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        // 'Used request-a-quote' => [
        //     'url-match' => '/\\/(?:used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
        //     'target' => null,
        //     //Don't move button
        //     'locations' => [
        //         'default' => null,
        //     ],
        //     'action-target' => 'a[href*=eprice-form].btn.ddc-btn',
        //     'css-class' => 'a[href*="eprice-form"].btn.ddc-btn',
        //     'css-hover' => 'a[href*="eprice-form"].btn.ddc-btn:hover',
        //     'button_action' => [
        //         'form',
        //         'e-price',
        //     ],
        //     'sizes' => [
        //         '100' => [],
        //     ],
        //     'texts' => [
        //         'request-a-quote' => [
        //             'target' => 'a[href*=eprice-form].btn.ddc-btn',
        //             'values' => array(
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Price Updates',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Local Pricing',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Best Price',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Current Market Price',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Internet Price Now',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get E-Price',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get your Price!',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Exclusive Price',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>SPECIAL PRICING!',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Special Price',
        //                 '<i class="ddc-icon ddc-icon-banknote"></i>Get Our Best Price',
        //             ),
        //         ],
        //     ],
        //     'styles' => array(
        //         'orange' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                 'border-color' => '#f06b20',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                 'border-color' => '#cf540e',
        //             ),
        //         ),
        //         'red' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#E01212,#E01212)',
        //                 'border-color' => '#e01212',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
        //                 'border-color' => '#c60c0d',
        //             ),
        //         ),
        //         'green' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#54B740,#54B740)',
        //                 'border-color' => '#54b740',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#359D22,#359D22)',
        //                 'border-color' => '#359d22',
        //             ),
        //         ),
        //         'blue' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
        //                 'border-color' => '#1ca0d1',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#188BB7,#188BB7)',
        //                 'border-color' => '#188bb7',
        //             ),
        //         ),
        //     ),
        // ],
        'request-information' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=vehiclelead-form].btn.ddc-btn',
            'css-class' => 'a[href*="vehiclelead-form"].btn.ddc-btn',
            'css-hover' => 'a[href*="vehiclelead-form"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a[href*=vehiclelead-form].btn.ddc-btn',
                    'values' => array(
                        'More Info',
                        'Ask an Expert!',
                        'Get More Information',
                        'Get More Info',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=trade].btn.ddc-btn',
            'css-class' => 'a[href*="trade"].btn.ddc-btn',
            'css-hover' => 'a[href*="trade"].btn.ddc-btn:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade].btn.ddc-btn',
                    'values' => array(
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'Trade Offer',
                        'Trade-in your ride',
                        'Appraise Your Trade',
                        'Get Trade-In Value',
                        'What\'s Your Trade Worth',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/.*(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=financing].btn.ddc-btn.btn-default',
            'css-class' => 'a[href*="financing"].btn.ddc-btn.btn-default',
            'css-hover' => 'a[href*="financing"].btn.ddc-btn.btn-default:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing].btn.ddc-btn.btn-default',
                    'values' => array(
                        'Financing Options',
                        'Calculate Your Payments',
                        'Payment Options',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
],
);