<?php

global $CronConfigs;
$CronConfigs["quillplains"] = array(
    'password' => 'quillplains',
    "email" => "regan@smedia.ca",
    'log' => true,
    'customer_id' => '492-987-2005',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "lead" => array(
        'display_after' => 30000,
        'retarget_after' => 5000,
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#FAC703',
            '#FAC703',
),
        'button_color_hover' => array(
            '#E1A504',
            '#E1A504',
),
        'button_color_active' => array(
            '#E1A504',
            '#E1A504',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 off with this offer from Quill Plains',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Quill Plains',
        'forward_to' => array(
            'nfehr@quillplains.ca',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    "banner" => array(
        "template" => "quillplains",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead_to' => [
        'info@quillplains.ca',
        'nfehr@quillplains.ca',
],
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            // 'button_action' => ['form','e-price'],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'max_cost' => 50,
    'cost_distribution' => array(
        'new' => 25,
        'used' => 25,
),
);