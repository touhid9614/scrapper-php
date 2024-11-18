<?php

global $CronConfigs;
$CronConfigs["heritageromehonda"] = array(
    'password' => 'heritageromehonda',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "heritageromehonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'webleads@heritagerome.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\//i',
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
                        'Get More Information',
                        'Ask A Question',
                        'More Info',
                        'Get More Info',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/vehicle-details\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#makeAnOffer.link.hash-st_make_an_offer',
            'css-class' => 'a#makeAnOffer.link.hash-st_make_an_offer',
            'css-hover' => 'a#makeAnOffer.link.hash-st_make_an_offer:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a#makeAnOffer.link.hash-st_make_an_offer',
                    'values' => array(
                        'Buy Now',
                        'Start Purchase',
                        'Buy This Vehicle',
                        'Begin Purchase Process',
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
            'url-match' => '/\\/vehicle-details\\//i',
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
                        'Schedule My Visit',
                        'Test Drive',
                        'Test Drive Now',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
                        'Request Test Drive',
                        'Book Test Drive',
                        'Test Drive Today',
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
            'url-match' => '/\\/vehicle-details\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#getApproved.link',
            'css-class' => 'a#getApproved.link',
            'css-hover' => 'a#getApproved.link:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a#getApproved.link',
                    'values' => array(
                        'Calculate Monthly Payments',
                        'Calculate Financing',
                        'Calculate My Payments',
                        'Lease Options',
                        'Financing Options',
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
            'url-match' => '/\\/vehicle-details\\//i',
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
                'trade-in' => [
                    'target' => 'a#tradeIn.link',
                    'values' => array(
                        'Value Your Trade',
                        'Get Your Trade-In Value',
                        'Trade Appraisal',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
],
);