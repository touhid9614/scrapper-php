<?php

global $CronConfigs;
$CronConfigs["bockerautogroup"] = array(
    'password' => 'bockerautogroup',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "bockerautogroup",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'form_live' => false,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
                    'values' => array(
                        'Get Price Alerts',
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
),
],
],
            'styles' => array(
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#05055B,#05055B)',
                        'border-color' => '05055B',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#040441,#040441)',
                        'border-color' => '040441',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C49C33,#C49C33)',
                        'border-color' => 'C49C33',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9E7E29,#9E7E29)',
                        'border-color' => '9E7E29',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D81D24,#D81D24)',
                        'border-color' => 'D81D24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A71B20,#A71B20)',
                        'border-color' => 'A71B20',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#22D85D,#22D85D)',
                        'border-color' => '22D85D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1DB04D,#1DB04D)',
                        'border-color' => '1DB04D',
                        'color' => '#fff',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="f20bfe5f-597c-4011-a96e-7e0da3172914"]',
            'css-class' => 'a[name="f20bfe5f-597c-4011-a96e-7e0da3172914"]',
            'css-hover' => 'a[name="f20bfe5f-597c-4011-a96e-7e0da3172914"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[name="f20bfe5f-597c-4011-a96e-7e0da3172914"]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#22D85D,#22D85D)',
                        'border-color' => '22D85D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1DB04D,#1DB04D)',
                        'border-color' => '1DB04D',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C49C33,#C49C33)',
                        'border-color' => 'C49C33',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9E7E29,#9E7E29)',
                        'border-color' => '9E7E29',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D81D24,#D81D24)',
                        'border-color' => 'D81D24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A71B20,#A71B20)',
                        'border-color' => 'A71B20',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#05055B,#05055B)',
                        'border-color' => '05055B',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#040441,#040441)',
                        'border-color' => '040441',
                        'color' => '#fff',
),
),
),
],
],
);