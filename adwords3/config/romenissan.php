<?php

global $CronConfigs;
$CronConfigs["romenissan"] = array(
    'password' => 'romenissan',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "romenissan",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'smart_banner' => array(
        'live' => null,
        'title' => '',
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17588',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'adf_to' => array(
        'nissanweblead@heritagerome.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.btn.btn-default.hash-st_request_a_quote',
            'css-class' => 'button.btn.btn-default.hash-st_request_a_quote',
            'css-hover' => 'button.btn.btn-default.hash-st_request_a_quote:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button.btn.btn-default.hash-st_request_a_quote',
                    'values' => array(
                        'Get E-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Check Availability',
                        'Get Special Price!',
                        'Special Pricing!',
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
        'request-information' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.link.hash-st_make_an_offer[href *=make-an-offer]',
            'css-class' => 'a.link.hash-st_make_an_offer[href *=make-an-offer]',
            'css-hover' => 'a.link.hash-st_make_an_offer[href *=make-an-offer]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a.link.hash-st_make_an_offer[href *=make-an-offer]',
                    'values' => array(
                        'Get Your Price',
                        'Get Our Best Price',
                        'Get Internet Price',
                        'Get Special Pricing',
                        'Request a Quote',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#scheduleTestDrive.link.hash-st_schedule_testdrive',
            'css-class' => 'a#scheduleTestDrive.link.hash-st_schedule_testdrive',
            'css-hover' => 'a#scheduleTestDrive.link.hash-st_schedule_testdrive:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a#scheduleTestDrive.link.hash-st_schedule_testdrive',
                    'values' => array(
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#getApproved.link',
            'css-class' => 'a#getApproved.link',
            'css-hover' => 'a#getApproved.link:hover',
            //            'button_action' => [
            //                'form',
            //                'finance',
            //            ],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a#getApproved.link',
                    'values' => array(
                        'Get Financed Today',
                        'Explore Payments',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'Today\'s Market Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#tradeIn.link',
            'css-class' => 'a#tradeIn.link',
            'css-hover' => 'a#tradeIn.link:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a#tradeIn.link',
                    'values' => array(
                        'Value Your Trade',
                        'What\'s Your Trade Worth',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'padding' => '3px 5px',
                        'margin' => '3px 5px',
                        'text-decoration' => 'none',
),
),
),
],
],
);