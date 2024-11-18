<?php

global $CronConfigs;
$CronConfigs["joeleechevy"] = array(
    "name" => " joeleechevy",
    "email" => "regan@smedia.ca",
    "password" => " joeleechevy",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "joeleechevy",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
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
            '#1E4387',
            '#1E4387',
        ),
        'button_color_hover' => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$100 in GM Accessories from Joe Lee Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Joe Lee Chevy Team',
        'forward_to' => array(
            'joeleechevy@gmail.com',
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
    'lead_to' => 'joeleechevy@gmail.com',
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
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
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
                    ),
                ],
            ],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ECA40A,#ECA40A)',
                        'border-color' => 'CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CE8F0A,#CE8F0A)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2811E5,#2811E5)',
                        'border-color' => '00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#240FCF,#240FCF)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B6094,#1B6094)',
                        'border-color' => '00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#17507B,#17507B)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
        //Price Watch///
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
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
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'price-watch' => [
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
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ECA40A,#ECA40A)',
                        'border-color' => 'CBAA4D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CE8F0A,#CE8F0A)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2811E5,#2811E5)',
                        'border-color' => '00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#240FCF,#240FCF)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B6094,#1B6094)',
                        'border-color' => '00426B',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#17507B,#17507B)',
                        'border-color' => '1E1C1D',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
    ],
);