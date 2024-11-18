<?php

global $CronConfigs;
$CronConfigs["gregweeks"] = array(
    "name" => " gregweeks",
    "email" => "regan@smedia.ca",
    "password" => " gregweeks",
    "log" => true,
    "banner" => array(
        "template" => "gregweeks",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#3271B6',
            '#3271B6',
),
        'button_color_hover' => array(
            '#F0B53E',
            '#F0B53E',
),
        'button_color_active' => array(
            '#F0B53E',
            '#F0B53E',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Weeks Chevrolet Buick GMC',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Weeks Chevrolet Buick GMC Team',
        'forward_to' => array(
            'michael@gregweeks.com',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    'lead_to' => array(
        'michael@gregweeks.com',
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
            'action-target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Today\'s Quote!',
                        'Get Quote',
                        'Ask for a Quote',
                        'Get A Quote',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A47927,#A47927)',
                        'border-color' => 'A47927',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E61212,#E61212)',
                        'border-color' => 'E61212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B61111,#B61111)',
                        'border-color' => 'B61111',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#41148C,#41148C)',
                        'border-color' => '41148C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#330F6E,#330F6E)',
                        'border-color' => '330F6E',
                        'color' => '#fff',
),
),
),
],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
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
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A47927,#A47927)',
                        'border-color' => 'A47927',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E61212,#E61212)',
                        'border-color' => 'E61212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B61111,#B61111)',
                        'border-color' => 'B61111',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#41148C,#41148C)',
                        'border-color' => '41148C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#330F6E,#330F6E)',
                        'border-color' => '330F6E',
                        'color' => '#fff',
),
),
),
],
],
);