<?php

global $CronConfigs;
$CronConfigs["kelownatoyota"] = array(
    'password' => 'kelownatoyota',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "kelownatoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'leads@kelownatoyota.motosnap.com',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(certified-)?(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.button.cta-button.block.button-form.fancybox',
            'css-class' => '.button.cta-button.block.button-form.fancybox',
            'css-hover' => '.button.cta-button.block.button-form.fancybox:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Best Price',
                        'Get Current Market Price',
                        'Get E-Price',
                        'Get Your Price!',
                        'Get Price Updates',
                        'Local Pricing',
                        'Confirm Availability',
                        'Get Your Exclusive Price',
),
],
],
            'styles' => array(
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '086597',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '086597',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE8100,#EE8100)',
                        'border-color' => 'EE8100',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A84E,#00A84E)',
                        'border-color' => '00A84E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '086597',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
],
);