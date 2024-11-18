<?php

global $CronConfigs;
$CronConfigs["mapleridge_vw"] = array(
    "name" => " mapleridge_vw",
    "email" => "regan@smedia.ca",
    "password" => " mapleridge_vw",
    "log" => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => no,
        "used_placement" => no,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => no,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '599-864-0912',
    "banner" => array(
        "template" => "mapleridge_vw",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0070BB',
            '#0070BB',
),
        'button_color_hover' => array(
            '#003D66',
            '#003D66',
),
        'button_color_active' => array(
            '#003D66',
            '#003D66',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $500 cash back from Maple Ridge Volkswagen',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Maple Ridge Volkswagen Team',
        'forward_to' => array(
            'salesmanager@mapleridgevw.com',
            'marshal@smedia.ca',
            ' ',
),
        'special_to' => array(
            'leads@mapleridgevolkswagen.motosnap.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.maincta-row.ctabox-row .button.cta-button',
            'css-class' => '.maincta-row.ctabox-row .button.cta-button',
            'css-hover' => '.maincta-row.ctabox-row .button.cta-button:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.maincta-row.ctabox-row .button.cta-button',
                    'values' => array(
                        'Get Internet Price',
                        'Get Special Price',
                        'Get A Quote',
                        'Request A Quote',
                        'Get Your Price',
                        'Get Price Updates',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B41819,#B41819)',
                        'border-color' => 'B41819',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C21919,#C21919)',
                        'border-color' => 'C21919',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008000,#008000)',
                        'border-color' => '008000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#00CC00,#00CC00)',
                        'border-color' => '00CC00',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0093BF,#0093BF)',
                        'border-color' => '0093BF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#009CCC,#009CCC)',
                        'border-color' => '009CCC',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#004B99,#004B99)',
                        'border-color' => '004B99',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006FE6,#006FE6)',
                        'border-color' => '006FE6',
),
),
),
],
],
);