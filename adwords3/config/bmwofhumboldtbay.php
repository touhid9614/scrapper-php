<?php

global $CronConfigs;
$CronConfigs["bmwofhumboldtbay"] = array(
    "name" => " bmwofhumboldtbay",
    "email" => "regan@smedia.ca",
    "password" => " bmwofhumboldtbay",
    "log" => true,
    "banner" => array(
        "template" => "bmwofhumboldtbay",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
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
            "#2594cd",
            "#2594cd",
),
        'button_color_hover' => array(
            "#165e82",
            "#165e82",
),
        'button_color_active' => array(
            "#165e82",
            "#165e82",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$250 off coupon from BMW of Humboldt Bay",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>BMW of Humboldt Bay Team",
        'forward_to' => array(
            "linus@mckchevy.com",
            "syman@mckchevy.com",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'lead_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'trade-in' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=tradein].btn',
            'css-class' => 'a[href*=tradein].btn',
            'css-hover' => 'a[href*=tradein].btn:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=tradein].btn',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'FF0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC0303,#DC0303)',
                        'border-color' => 'DC0303',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#404040,#404040)',
                        'border-color' => '404040',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '171717',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#137EB8,#137EB8)',
                        'border-color' => '137EB8',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0D618F,#0D618F)',
                        'border-color' => '0D618F',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[href*=testdrive].btn.btn-primary.dialog.btn-block',
            'css-class' => '[href*=testdrive].btn.btn-primary.dialog.btn-block',
            'css-hover' => '[href*=testdrive].btn.btn-primary.dialog.btn-block:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '[href*=testdrive].btn.btn-primary.dialog.btn-block',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'FF0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC0303,#DC0303)',
                        'border-color' => 'DC0303',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#404040,#404040)',
                        'border-color' => '404040',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '171717',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#137EB8,#137EB8)',
                        'border-color' => '137EB8',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0D618F,#0D618F)',
                        'border-color' => '0D618F',
),
),
),
],
],
);