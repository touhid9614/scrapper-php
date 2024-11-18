<?php

global $CronConfigs;
$CronConfigs["basswoodcdjr"] = array(
    'password' => 'basswoodcdjr',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "basswoodcdjr",
        "fb_description" => "Are you still interested in the [year] [make] [model] [trim]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] [trim] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.eprice.dialog.button',
            'css-class' => 'a.btn.eprice.dialog.button',
            'css-hover' => 'a.btn.eprice.dialog.button:hover',
            // 'button_action' => ['form','e-price'],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.eprice.dialog.button',
                    'values' => array(
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'Get E-Price',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
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