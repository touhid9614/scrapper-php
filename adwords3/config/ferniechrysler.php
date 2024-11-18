<?php

global $CronConfigs;
$CronConfigs["ferniechrysler"] = array(
    "name" => " ferniechrysler",
    "email" => "regan@smedia.ca",
    "password" => " ferniechrysler",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "dealership",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    //    "lead" => array(
    //        'live' => false,
    //        'lead_type_' => true,
    //        'lead_type_new' => true,
    //        'lead_type_used' => true,
    //        'bg_color' => '#EFEFEF',
    //        'text_color' => '#404450',
    //        'border_color' => '#E5E5E5',
    //        'button_color' => array(
    //            '#861316',
    //            '#861316',
    //        ),
    //        'button_color_hover' => array(
    //            '#1F1F1F',
    //            '#1F1F1F',
    //        ),
    //        'button_color_active' => array(
    //            '#1F1F1F',
    //            '#1F1F1F',
    //        ),
    //        'button_text_color' => '#FFFFFF',
    //        'response_email_subject' => '$200 off coupon from Fernie Chrysler',
    //        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fernie Chrysler Team',
    //        'forward_to' => array(
    //            'johnfendley@ferniechrysler.com',
    //            'shawnpotyok@ferniechrysler.com',
    //            'marshal@smedia.ca',
    //        ),
    //        'respond_from' => 'offers@mail.smedia.ca',
    //        'forward_from' => 'offers@mail.smedia.ca',
    //        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    //    ),
    'lead_to' => array(
        'johnfendley@ferniechrysler.com',
        'shawnpotyok@ferniechrysler.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.eprice-link a[href*=vdp-contact-form]',
            'css-class' => 'div.eprice-link a[href*=vdp-contact-form]',
            'css-hover' => 'div.eprice-link a[href*=vdp-contact-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.eprice-link a[href*=vdp-contact-form]',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'Get Current Market Price',
                        'Special Pricing',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Get Your Exclusive Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#AE1B1B,#AE1B1B)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#941717,#941717)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#597DDA,#597DDA)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4F6EC0,#4F6EC0)',
                        'border-color' => '188BB7',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#898C8D,#898C8D)',
                        'border-color' => '188BB7',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#898C8D,#898C8D)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
],
],
);