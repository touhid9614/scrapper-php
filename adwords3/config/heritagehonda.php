<?php

global $CronConfigs;
$CronConfigs["heritagehonda"] = array(
    "name" => " heritagehonda",
    "email" => "regan@smedia.ca",
    "password" => " heritagehonda",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "heritagehonda",
        "fb_description" => "Are you still interested in the [year] [make] [model] [trim]? You can buy a car from home. Learn more about our Dilawri Anywhere program.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] [trim] today! You can buy a car from home. Learn more about our Dilawri Anywhere program.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'buttons' => [
        'Used trade-in' => [
            'url-match' => '/\\/en\\/used-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="/en/form/trade-in"]',
            'css-class' => 'a[href*="/en/form/trade-in"]',
            'css-hover' => 'a[href*="/en/form/trade-in"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*="/en/form/trade-in"]',
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
                'gray' => array(
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
            'url-match' => '/\\/en\\/new-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="/en/form/new-inventory/tradein-appraisal"]',
            'css-class' => 'a[href*="/en/form/new-inventory/tradein-appraisal"]',
            'css-hover' => 'a[href*="/en/form/new-inventory/tradein-appraisal"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*="/en/form/new-inventory/tradein-appraisal"]',
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
                'light-blue' => array(
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
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/en\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.link__alpha.link__alpha-primary.inventory-vehicle-infos__actions-item',
            'css-class' => 'a.link__alpha.link__alpha-primary.inventory-vehicle-infos__actions-item',
            'css-hover' => 'a.link__alpha.link__alpha-primary.inventory-vehicle-infos__actions-item:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.link__alpha.link__alpha-primary.inventory-vehicle-infos__actions-item',
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
                'gray' => array(
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
        'Used test-drive' => [
            'url-match' => '/\\/en\\/used-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="/en/form/road-test-used"]',
            'css-class' => 'a[href*="/en/form/road-test-used"]',
            'css-hover' => 'a[href*="/en/form/road-test-used"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*="/en/form/road-test-used"]',
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
                'gray' => array(
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
            'url-match' => '/\\/en\\/new-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="/en/form/road-test"]',
            'css-class' => 'a[href*="/en/form/road-test"]',
            'css-hover' => 'a[href*="/en/form/road-test"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*="/en/form/road-test"]',
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
                'light-blue' => array(
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
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/en\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="/en/form/financing"]',
            'css-class' => 'a[href*="/en/form/financing"]',
            'css-hover' => 'a[href*="/en/form/financing"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*="/en/form/financing"]',
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
                'gray' => array(
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17587',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);