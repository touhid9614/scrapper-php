<?php

global $CronConfigs;
$CronConfigs["calgarybmw"] = array(
    "name" => " calgarybmw",
    "email" => "regan@smedia.ca",
    "password" => " calgarybmw",
    "log" => true,
    "fb_brand" => "[year] [make] [model] - [body_style]",
    "banner" => array(
        "template" => "calgarybmw",
        "fb_description" => "Are you still interested in the [year] [make] [model]? You can buy a car from home. Learn more about our Dilawri Anywhere program.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]. You can buy it from home. Learn more about our Dilawri Anywhere program.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead_to' => array(
        'bdc@dilawri-group.ca',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.inventory-vehicle-infos__actions a:nth-of-type(1)',
            'css-class' => 'div.inventory-vehicle-infos__actions a:nth-of-type(1)',
            'css-hover' => 'div.inventory-vehicle-infos__actions a:nth-of-type(1):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.inventory-vehicle-infos__actions a:nth-of-type(1)',
                    'values' => array(
                        'Watch This Price',
                        'Special Pricing!',
                        'Current Market Price',
                        'Best Price',
                        'Get Internet Special',
                        'Get Special Price!',
                        'Internet Price',
                        'Get Your E-Price',
                        'Get Our Best Price',
                        'Today\'s Market Price',
                        'Get Special Price',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
                        'border-color' => '0C9DDA',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
                        'border-color' => 'B4B4B4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '111111',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *="/en/form/road-test',
            'css-class' => 'a[href *="/en/form/road-test',
            'css-hover' => 'a[href *="/en/form/road-test:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href *=road-test]',
                    'values' => array(
                        'Book a Test Drive',
                        'Test Drive Now',
                        'TEST RIDE',
                        'Want to Test Drive?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
                        'border-color' => '0C9DDA',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
                        'border-color' => 'B4B4B4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '111111',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *="new-inventory/tradein-appraisal"]',
            'css-class' => 'a[href *="new-inventory/tradein-appraisal"]',
            'css-hover' => 'a[href *="new-inventory/tradein-appraisal"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href *="new-inventory/tradein-appraisal"]',
                    'values' => array(
                        'Appraise my trade in',
                        'Value your trade',
                        'What\'s your trade worth?',
                        'We want your car',
                        'Trade Value',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
                        'border-color' => '0C9DDA',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
                        'border-color' => 'B4B4B4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '111111',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=financing-request]',
            'css-class' => 'a[href *=financing-request]',
            'css-hover' => 'a[href *=financing-request]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href *=financing-request]',
                    'values' => array(
                        'Special Finance Offers',
                        'Financing Options',
                        'Calculate my Payments',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
                        'border-color' => '0C9DDA',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
                        'border-color' => 'B4B4B4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#111111,#111111)',
                        'border-color' => '111111',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
),
),
),
],
],
);