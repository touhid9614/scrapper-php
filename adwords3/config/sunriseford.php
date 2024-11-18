<?php

global $CronConfigs;
$CronConfigs["sunriseford"] = array(
    'password'     => 'sunriseford',
    "email"        => "regan@smedia.ca",
    'log'          => true,
    'fb_brand'     => '[year] [make] [model] - [body_style]',
    "banner"       => array(
        "template"                 => "sunriseford",
        "fb_description"           => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style"              => "default",
        "border_color"             => "#282828",
        "font_color"               => "#ffffff",
    ),
    "lead"         => array(
        'live'                   => false,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'lead_type_service'      => false,
        'shown_cap'              => false,
        'fillup_cap'             => false,
        'session_close'          => false,
        'device_type'            => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#3489FF',
            '#3489FF',
        ),
        'button_color_hover'     => array(
            '#3D4048',
            '#3D4048',
        ),
        'button_color_active'    => array(
            '#3D4048',
            '#3D4048',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $500 more towards your trade',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sunrise Ford Team',
        'forward_to'             => array(
            'leon@sunriseford.ca',
            'marshal@smedia.ca',
            'sales@sunriseford.ca',
        ),
        'special_to'             => array(
            '',
        ),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'video_smart_offer'      => false,
        'video_smart_offer_form' => false,
        'video_url'              => '',
        'video_title'            => '',
        'video_description'      => '',
        'lead_in'                => array(
            'vdp'     => '/\\/(?:new|pre-owned|certified)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-.*\\.html/i',
            'service' => '',
        ),
    ),
    'lead_to'      => array(
        'gavin@sunriseford.ca',
    ),
    'form_live'    => false,
    'buttons_live' => false,
    'buttons'      => [
        'request-a-quote' => [
            'url-match'     => '/\\/(?:new|certified|pre-owned)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target'        => null,
            // Don't move button
            'locations'     => [
                'default' => null,
            ],
            'action-target' => '[data-page="templates/get-your-eprice"]',
            'css-class'     => '[data-page="templates/get-your-eprice"]',
            'css-hover'     => '[data-page="templates/get-your-eprice"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes'         => [
                '100' => [],
            ],
            'texts'         => [
                'request-a-quote' => [
                    'target' => '[data-page="templates/get-your-eprice"]',
                    'values' => array(
                        'Get Internet Price',
                        'Get e-Price',
                        'Get Sale Price',
                        'Current Market Price',
                        'Today\'s Market Price',
                        'Request a Quote',
                        'Get a Quote',
                        'Inquire Now',
                        'Inquire Today',
                    ),
                ],
            ],
            'styles'        => array(
                'dark-blue' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#0D2F4D,#0D2F4D)',
                        'border-color' => 'E01212',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#071A2B,#071A2B)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'dark-gray' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#616161,#616161)',
                        'border-color' => 'E01212',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#434343,#434343)',
                        'border-color' => 'C60C0D',
                    ),
                ),
            ),
        ],
    ],
);
