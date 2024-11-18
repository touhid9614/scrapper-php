<?php

global $CronConfigs;
$CronConfigs["seattlemini"] = array(
    'password' => 'seattlemini',
    "email" => "regan@smedia.ca",
    'log' => true,
    'customer_id' => '106-797-6270',
    'max_cost' => 4000,
    'cost_distribution' => array(
        'adwords' => 4000,
    ),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "seattlemini",
        'fb_description' => 'Still interested? Click here to digitally test drive the [year] [make] [model]!',
        'fb_lookalike_description' => 'Click here to digitally test drive the [year] [make] [model]!',
        "flash_style" => "default",
        "border_color" => "#282828",
        'fb_style' => 'northwestmini',
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'seattlemini@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
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
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        'Request a Quote',
                        'Request a Quote!',
                        'More Info',
                        'More Info!',
                        'Get More Info',
                        'Get More Info!',
                        'Contact Us',
                        'Contact Us!',
                        'More Information!',
                        'More Information',
                        'Get a Quote!',
                        'Get a Quote',
                        'Confirm Availability',
                        'Confirm Availability!',
                        'Ask A Question',
                        'Ask A Question!',
                        'Have a Question?',
                        'Question?',
                        'Ask An Expert',
                        'Ask An Expert!',
                        'Learn More',
                        'Learn More!',
                        'Request More Info',
                        'More Details',
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
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17607',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);