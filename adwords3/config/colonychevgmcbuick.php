<?php

global $CronConfigs;

$CronConfigs["colonychevgmcbuick"] = array(
    'name'         => 'colonychevgmcbuick',
    'email'        => 'regan@smedia.ca',
    'password'     => 'colonychevgmcbuick',
    'log'          => true,
    'banner'       => array(
        'template'                   => 'colonychevgmcbuick',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_marketplace_description' => '[description]',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'         => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
        'lead_type_used'         => false,
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
            '#004986',
            '#004986',
        ),
        'button_color_hover'     => array(
            '#F92913',
            '#F92913',
        ),
        'button_color_active'    => array(
            '#F92913',
            '#F92913',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 coupon from Colony Chevrolet GMC Buick',
        'response_email'         => 'Hello [name],<p> Thank you for shopping at Colony Chevrolet GMC Buick! Here\'s your offer!  Please print this coupon, or show your sales professional this email on your phone to claim.
        We ask that this incentive is presented prior to finalizing payments and/or pricing within 30 days of issue. Coupon not valid after sale agreement has been reached. </p><br><img src="[image]"/><p><br><br>Colony Chevrolet GMC BuickTeam',
        'forward_to'             => array(
            'kevin@colonychevgmcbuick.com',
            'jerry@colonychevgmcbuick.com',
            'marshal@smedia.ca',
        ),
        'special_to'             => array(),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'lead_in'                => array(
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
        ),
    ),
    'lead_to'      => array(
        'kevin@colonychevgmcbuick.com',
        'jerry@colonychevgmcbuick.com',
    ),
    'form_live'    => true,
    'buttons_live' => true,
    'buttons'      => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class'     => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover'     => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
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
                ),
            ),
            'styles'        => array(
                'green' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#29BD4C,#29BD4C)',
                        'border-color' => '29BD4C',
                        'color'        => '#fff',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#20933B,#20933B)',
                        'border-color' => '20933B',
                        'color'        => '#fff',
                    ),
                ),
                'red'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#FF2715,#FF2715)',
                        'border-color' => 'FF2715',
                        'color'        => '#fff',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#D41F10,#D41F10)',
                        'border-color' => 'D41F10',
                        'color'        => '#fff',
                    ),
                ),
                'blue'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#014984,#014984)',
                        'border-color' => '014984',
                        'color'        => '#fff',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#01325B,#01325B)',
                        'border-color' => '01325B',
                        'color'        => '#fff',
                    ),
                ),
            ),
        ),
    ),
);