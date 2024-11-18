<?php

global $CronConfigs;
$CronConfigs["bellinghamchevy"] = array(
    "name" => " bellinghamchevy",
    "email" => "regan@smedia.ca",
    "password" => " bellinghamchevy",
    "log" => true,
    "banner" => array(
        "template" => "bellinghamchevy",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
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
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
            'css-class' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
            'css-hover' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price Now',
                        'Get Your Price',
                        'Get Special Price',
                        'Get Your Exclusive Price',
                        'Get Current Market Price',
                        'Get E-Price Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B53F45,#B53F45)',
                        'border-color' => 'B53F45',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C363B,#9C363B)',
                        'border-color' => '9C363B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0800E6,#0800E6)',
                        'border-color' => '0800E6',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#05009A,#05009A)',
                        'border-color' => '05009A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#80C142,#80C142)',
                        'border-color' => '80C142',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6FA839,#6FA839)',
                        'border-color' => '6FA839',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#525151,#525151)',
                        'border-color' => '525151',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
        'request-information' => [
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
                'request-information' => [
                    'target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
                    'values' => array(
                        'Price Update',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B53F45,#B53F45)',
                        'border-color' => 'B53F45',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C363B,#9C363B)',
                        'border-color' => '9C363B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0800E6,#0800E6)',
                        'border-color' => '0800E6',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#05009A,#05009A)',
                        'border-color' => '05009A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#80C142,#80C142)',
                        'border-color' => '80C142',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6FA839,#6FA839)',
                        'border-color' => '6FA839',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#525151,#525151)',
                        'border-color' => '525151',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="9cce1b47-c05c-4fa2-9ec1-6ddc2609bbaa"]',
            'css-class' => 'a[name="9cce1b47-c05c-4fa2-9ec1-6ddc2609bbaa"]',
            'css-hover' => 'a[name="9cce1b47-c05c-4fa2-9ec1-6ddc2609bbaa"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[name="9cce1b47-c05c-4fa2-9ec1-6ddc2609bbaa"]',
                    'values' => array(
                        'Apply For Financing',
                        'Special Finance Offers',
                        'Get Financed Today',
                        'Financing Available',
                        'Estimate Payments',
                        'Calculate Your Payments',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B53F45,#B53F45)',
                        'border-color' => 'B53F45',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C363B,#9C363B)',
                        'border-color' => '9C363B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0800E6,#0800E6)',
                        'border-color' => '0800E6',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#05009A,#05009A)',
                        'border-color' => '05009A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#80C142,#80C142)',
                        'border-color' => '80C142',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6FA839,#6FA839)',
                        'border-color' => '6FA839',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#525151,#525151)',
                        'border-color' => '525151',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
],
);