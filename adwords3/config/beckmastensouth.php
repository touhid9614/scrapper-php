<?php

global $CronConfigs;
$CronConfigs["beckmastensouth"] = array(
    "name" => " beckmastensouth",
    "email" => "regan@smedia.ca",
    "password" => " beckmastensouth",
    "log" => true,
    'combined_feed_mode' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "beckmastensouth",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information or visit us at 12820 Gulf Fwy, Houston, TX 77034, United States.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]. Click for more information or visit us at 12820 Gulf Fwy, Houston, TX 77034, United States.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified-used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Today\'s Quote!',
                        'Get Quote',
                        'Ask for a Quote',
                        'Get A Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0864A5,#0864A5)',
                        'border-color' => '0864A5',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0A5082,#0A5082)',
                        'border-color' => '0A5082',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BAC1CB,#BAC1CB)',
                        'border-color' => 'BAC1CB',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#939495,#939495)',
                        'border-color' => '939495',
                        'color' => '#fff',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#63C0DE,#63C0DE)',
                        'border-color' => '63C0DE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#509BB3,#509BB3)',
                        'border-color' => '509BB3',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified-used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
            'css-class' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
            'css-hover' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="ed2bc13e-80fa-4084-bdd6-b9ab09cc9b9c"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BAC1CB,#BAC1CB)',
                        'border-color' => 'BAC1CB',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#939495,#939495)',
                        'border-color' => '939495',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0864A5,#0864A5)',
                        'border-color' => '0864A5',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0A5082,#0A5082)',
                        'border-color' => '0A5082',
                        'color' => '#fff',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#63C0DE,#63C0DE)',
                        'border-color' => '63C0DE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#509BB3,#509BB3)',
                        'border-color' => '509BB3',
                        'color' => '#fff',
),
),
),
],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified-used)-[0-9]{4}-/i',
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
                'price-watch' => [
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0864A5,#0864A5)',
                        'border-color' => '0864A5',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0A5082,#0A5082)',
                        'border-color' => '0A5082',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BAC1CB,#BAC1CB)',
                        'border-color' => 'BAC1CB',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#939495,#939495)',
                        'border-color' => '939495',
                        'color' => '#fff',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#63C0DE,#63C0DE)',
                        'border-color' => '63C0DE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#509BB3,#509BB3)',
                        'border-color' => '509BB3',
                        'color' => '#fff',
),
),
),
],
],
);