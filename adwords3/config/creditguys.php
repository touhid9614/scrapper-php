<?php

global $CronConfigs;
$CronConfigs["creditguys"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'creditguys',
    'post_code' => 't18 4p8',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "email" => "regan@smedia.ca",
    //'customer_id' => '203-230-5294',
    'max_cost' => 600.0,
    'cost_distribution' => array(
        'adwords' => 600,
),
    'log' => true,
    "banner" => array(
        "template" => "creditguys",
        "fb_description" => "Are you still interested in the [year] [make] [model]? We have financing available for all levels of credit and we encourage you to apply for pre-approval today!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! We have financing available for all levels of credit and we encourage you to apply for pre-approval today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
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
            "#1b5d90",
            "#1b5d90",
),
        'button_color_hover' => array(
            "#123a59",
            "#123a59",
),
        'button_color_active' => array(
            "#123a59",
            "#123a59",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$250 off coupon from Credit Guys",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Credit Guys Team",
        'forward_to' => array(
            "kylelernout@creditguys.ca",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'lead_to' => array(
        'info@creditguys.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#discount',
            'css-class' => 'a#discount',
            'css-hover' => 'a#discount:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a#discount',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
        'Used financing' => [
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-class' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-hover' => 'button#apply-for-finance.btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'button#apply-for-finance.btn-orange-vehicles1',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
        'Used request-information' => [
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button#request-info.btn-orange-vehicles1',
            'css-class' => 'button#request-info.btn-orange-vehicles1',
            'css-hover' => 'button#request-info.btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'button#request-info.btn-orange-vehicles1',
                    'values' => array(
                        'Request Information',
                        'Get More Information',
                        'Ask for More Info',
                        'Ask an Expert',
                        'Ask a Question',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
);