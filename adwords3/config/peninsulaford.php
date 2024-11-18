<?php

global $CronConfigs;
$CronConfigs["peninsulaford"] = array(
    "name" => " peninsulaford",
    "email" => "regan@smedia.ca",
    "password" => " peninsulaford",
    "log" => true,
    "banner" => array(
        "template" => "peninsulaford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#2B8BC5",
            "#2B8BC5",
),
        'button_color_hover' => array(
            "#D17A37",
            "#D17A37",
),
        'button_color_active' => array(
            "#D17A37",
            "#D17A37",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Peninsula Ford",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Peninsula Ford Team",
        'forward_to' => array(
            "kwismer@peninsulaford.com",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    //    'adf_to' => array(
    //        '',
    //    ),
    // 'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/+[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a:nth-of-type(1)[onclick*="fireGAPageViewsEventsNew"]',
            'css-class' => 'a:nth-of-type(1)[onclick*="fireGAPageViewsEventsNew"]',
            'css-hover' => 'a:nth-of-type(1)[onclick*="fireGAPageViewsEventsNew"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a:nth-of-type(1)[onclick*="fireGAPageViewsEventsNew"]',
                    'values' => array(
                        'Get Sale Price',
                        'Special Pricing',
                        'Inquire Now',
                        'Request a Quote',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'light-blue' => array(
                    'orange' => array(
                        'normal' => array(
                            'background' => 'linear-gradient(#FF6900,#FF6900)',
                            'border-color' => '#FF6900',
                            'color' => '#fff',
                            'font-size' => '15px',
                            'margin' => '10px 0 0',
                            'padding' => '9px 10px',
                            'text-align' => 'center',
),
                        'hover' => array(
                            'background' => 'linear-gradient(#D15702,#D15702)',
                            'border-color' => '#D15702',
                            'color' => '#fff',
                            'font-size' => '15px',
                            'margin' => '10px 0 0',
                            'padding' => '9px 10px',
                            'text-align' => 'center',
),
),
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '0B9EEB',
                        'color' => '#fff',
                        'font-size' => '15px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0679B6,#0679B6)',
                        'border-color' => '0679B6',
                        'color' => '#fff',
                        'font-size' => '15px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06336C,#06336C)',
                        'border-color' => '06336C',
                        'color' => '#fff',
                        'font-size' => '15px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#06244A,#06244A)',
                        'border-color' => '06244A',
                        'color' => '#fff',
                        'font-size' => '15px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/+[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[onclick*=BookATestDrive]',
            'css-class' => 'a[onclick*=BookATestDrive]',
            'css-hover' => 'a[onclick*=BookATestDrive]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[onclick*=BookATestDrive]',
                    'values' => array(
                        'Schedule My Visit',
                        'Want to Test Drive It?',
                        'Request a Test Drive',
                        'Book your Test Drive',
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '0B9EEB',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0679B6,#0679B6)',
                        'border-color' => '0679B6',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06336C,#06336C)',
                        'border-color' => '06336C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#06244A,#06244A)',
                        'border-color' => '06244A',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#,#)',
                        'border-color' => null,
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#,#)',
                        'border-color' => null,
                        'color' => '#fff',
),
),
),
],
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/+[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.book-a-test-drive-button-container',
            'css-class' => '.book-a-test-drive-button-container',
            'css-hover' => '.book-a-test-drive-button-container:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.book-a-test-drive-button-container',
                    'values' => array(
                        'Schedule My Visit',
                        'Want to Test Drive It?',
                        'Request a Test Drive',
                        'Book your Test Drive',
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '0B9EEB',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0679B6,#0679B6)',
                        'border-color' => '0679B6',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06336C,#06336C)',
                        'border-color' => '06336C',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#06244A,#06244A)',
                        'border-color' => '06244A',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#,#)',
                        'border-color' => null,
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#,#)',
                        'border-color' => null,
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
],
],
);