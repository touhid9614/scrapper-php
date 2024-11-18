<?php

global $CronConfigs;
$CronConfigs["gvw"] = array(
    "name" => " gvw",
    "email" => "regan@smedia.ca",
    "password" => " gvw",
    "log" => true,
    "banner" => array(
        "template" => "gvw",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#0db1f4",
            "#0db1f4",
),
        'button_color_hover' => array(
            "#2274ac",
            "#2274ac",
),
        'button_color_active' => array(
            "#2274ac",
            "#2274ac",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Guelph Volkswagen",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Guelph VW Team",
        'forward_to' => array(
            "zkukic@gvw.ca",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'Used request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.inventory-details__header-cta',
            'css-class' => '.inventory-details__header-cta',
            'css-hover' => '.inventory-details__header-cta:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.inventory-details__header-cta',
                    'values' => array(
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#385FBC,#385FBC)',
                        'border-color' => '385FBC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D4C98,#2D4C98)',
                        'border-color' => '2D4C98',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AA0C18,#AA0C18)',
                        'border-color' => 'AA0C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8C0913,#8C0913)',
                        'border-color' => '8C0913',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FAAA00,#FAAA00)',
                        'border-color' => 'FAAA00',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D59100,#D59100)',
                        'border-color' => 'D59100',
                        'color' => '#fff',
),
),
),
],
        'Used check-availibility' => [
            'url-match' => '/\\/en/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=vehicle-availability]',
            'css-class' => 'a[href *=vehicle-availability]',
            'css-hover' => 'a[href *=vehicle-availability]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href *=vehicle-availability]',
                    'values' => array(
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FAAA00,#FAAA00)',
                        'border-color' => 'FAAA00',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D59100,#D59100)',
                        'border-color' => 'D59100',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AA0C18,#AA0C18)',
                        'border-color' => 'AA0C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8C0913,#8C0913)',
                        'border-color' => '8C0913',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#385FBC,#385FBC)',
                        'border-color' => '385FBC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D4C98,#2D4C98)',
                        'border-color' => '2D4C98',
                        'color' => '#fff',
),
),
),
],
        'Used test-drive' => [
            'url-match' => '/\\/en/inventory\\/(?:new|used)\\/vehicle\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.inventory-details__content-cta-roadtest.inline-block a[href *=road-test]',
            'css-class' => '.inventory-details__content-cta-roadtest.inline-block a[href *=road-test]',
            'css-hover' => '.inventory-details__content-cta-roadtest.inline-block a[href *=road-test]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.inventory-details__content-cta-roadtest.inline-block a[href *=road-test]',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Schedule a Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FAAA00,#FAAA00)',
                        'border-color' => 'FAAA00',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D59100,#D59100)',
                        'border-color' => 'D59100',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AA0C18,#AA0C18)',
                        'border-color' => 'AA0C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8C0913,#8C0913)',
                        'border-color' => '8C0913',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#385FBC,#385FBC)',
                        'border-color' => '385FBC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D4C98,#2D4C98)',
                        'border-color' => '2D4C98',
                        'color' => '#fff',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/details\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.catalog-details__content-cta-pricecheck.inline-block [href*="price-request"]',
            'css-class' => 'div.catalog-details__content-cta-pricecheck.inline-block [href*="price-request"]',
            'css-hover' => 'div.catalog-details__content-cta-pricecheck.inline-block [href*="price-request"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.catalog-details__content-cta-pricecheck.inline-block [href*="price-request"]',
                    'values' => array(
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#385fbc,#385fbc)',
                        'border-color' => '385fbc',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2d4c98,#2d4c98)',
                        'border-color' => '2d4c98',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#aa0c18,#aa0c18)',
                        'border-color' => 'aa0c18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8c0913,#8c0913)',
                        'border-color' => '8c0913',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#faaa00,#faaa00)',
                        'border-color' => 'faaa00',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#d59100,#d59100)',
                        'border-color' => 'd59100',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/details\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.catalog-details__content-cta-roadtest.inline-block [title*="Book Your Test Drive Now"]',
            'css-class' => 'div.catalog-details__content-cta-roadtest.inline-block [title*="Book Your Test Drive Now"]',
            'css-hover' => 'div.catalog-details__content-cta-roadtest.inline-block [title*="Book Your Test Drive Now"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.catalog-details__content-cta-roadtest.inline-block [title*="Book Your Test Drive Now"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Schedule a Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#faaa00,#faaa00)',
                        'border-color' => 'faaa00',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#d59100,#d59100)',
                        'border-color' => 'd59100',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#aa0c18,#aa0c18)',
                        'border-color' => 'aa0c18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8c0913,#8c0913)',
                        'border-color' => '8c0913',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#385fbc,#385fbc)',
                        'border-color' => '385fbc',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2d4c98,#2d4c98)',
                        'border-color' => '2d4c98',
                        'color' => '#fff',
),
),
),
],
],
);