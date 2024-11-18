<?php

global $CronConfigs;
$CronConfigs["stephenwadecom"] = array(
    "name"               => "stephenwadecom",
    "email"              => "regan@smedia.ca",
    "password"           => "stephenwadecom",
    "log"                => true,
    'customer_id'        => '146-436-5617',
    "combined_feed_mode" => true,
    "banner"             => array(
        "template"                 => "stephenwadecom",
        "fb_description"           => "Are you still interested in the [year] [make] [model]? Click for more info!",
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style"              => "default",
        "border_color"             => "#282828",
        "font_color"               => "#ffffff",
    ),
    'lead'               => array(
        'live'                      => false,
        'lead_type_'                => false,
        'lead_type_new'             => false,
        'lead_type_used'            => false,
        'lead_type_service'         => false,
        'shown_cap'                 => true,
        'fillup_cap'                => true,
        'session_close'             => true,
        'inactivity'                => false,
        'exit_intent'               => false,
        'session_depth'             => false,
        'campaign_cap_google'       => false,
        'campaign_cap_fb'           => false,
        'device_type'               => array(
            'mobile'  => false,
            'desktop' => false,
            'tablet'  => false,
        ),
        'sent_client_email'         => true,
        'offer_minimum_price'       => 0,
        'offer_maximum_price'       => 10000000,
        'bg_color'                  => '#EFEFEF',
        'text_color'                => '#404450',
        'border_color'              => '#E5E5E5',
        'button_color'              => array(
            '#000000',
            '#000000',
        ),
        'button_color_hover'        => array(
            '#222222',
            '#222222',
        ),
        'button_color_active'       => array(
            '#222222',
            '#222222',
        ),
        'button_text_color'         => '#FFFFFF',
        'forward_email_subject'     => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject'    => 'Claim $200 off any purchase on used vehicle',
        'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Stephen Wade Auto Team',
        'forward_to'                => array(
            '',
        ),
        'special_to'                => array(
            'bdccrmleads@stephenwade.com',
            'adf_to@smedia.ca',
        ),
        'special_email'             => '',
        'display_after'             => 20000,
        'retarget_after'            => 5000,
        'fb_retarget_after'         => 5000,
        'adword_retarget_after'     => 5000,
        'visit_count'               => 0,
        'shown_cap_count'           => 1,
        'fillup_cap_time_days'      => 30,
        'session_close_cap'         => 3,
        'inactivity_timeout'        => 600000,
        'exit_intent_timeout'       => 10000,
        'session_depth_page'        => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days'  => 7,
        'campaign_fb_cap_count'     => 3,
        'campaign_fb_cap_days'      => 7,
        'video_smart_offer'         => false,
        'video_smart_offer_form'    => false,
        'video_url'                 => '',
        'video_title'               => '',
        'video_description'         => '',
        'lead_in'                   => array(
            'vdp'           => '/\\/vehicles\\//i',
            'service_regex' => '',
        ),
        'custom_div'                => '',
        'provider_name'             => 'sMedia',
        'source'                    => 'sMedia smartoffer',
    ),
    // 'form_live'          => false,
    // 'buttons_live'       => false,
    // 'buttons'            => array(
    //     'financing' => array(
    //         // 'url-match'     => '/\\/vehicles\\/inventory-listing/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a[data-formtitle="Get Pre-Approved"]',
    //         'css-class'     => 'a[data-formtitle="Get Pre-Approved"]',
    //         'css-hover'     => 'a[data-formtitle="Get Pre-Approved"]:hover',
    //         'button_action' => array(
    //             'form',
    //             'finance',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'financing' => array(
    //                 'target' => 'a[data-formtitle="Get Pre-Approved"]',
    //                 'values' => array(
    //                     'Claim $200 Off',
    //                     'Get $200 Off',
    //                     '$200 discount',
    //                     'Claim $200 discount',
    //                     'Get $200 cashback',
    //                     '$200 Off Coupon',
    //                     'Get Your Discount',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#197DFF,#197DFF)',
    //                     'border-color' => '197DFF',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#0952B3,#0952B3)',
    //                     'border-color' => '0952B3',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'yellow' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#FF6000,#FF6000)',
    //                     'border-color' => 'FF6000',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#DE5400,#DE5400)',
    //                     'border-color' => 'DE5400',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#0952B3,#0952B3)',
    //                     'border-color' => '0952B3',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#084596,#084596)',
    //                     'border-color' => '084596',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#00FF59,#00FF59)',
    //                     'border-color' => '00FF59',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#00B33E,#00B33E)',
    //                     'border-color' => '00B33E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     // 'financing'      => array(
    //     //     'url-match'     => '/\\/vehicles\\/inventory-list/i',
    //     //     'target'        => null,
    //     //     'locations'     => array(
    //     //         'default' => null,
    //     //     ),
    //     //     'action-target' => 'a#smediasave',
    //     //     'css-class'     => 'a#smediasave',
    //     //     'css-hover'     => 'a#smediasave:hover',
    //     //     'button_action' => array(
    //     //         'form',
    //     //         'finance',
    //     //     ),
    //     //     'sizes'         => array(
    //     //         100 => array(),
    //     //     ),
    //     //     'texts'         => array(
    //     //         'financing' => array(
    //     //             'target' => 'a#smediasave',
    //     //             'values' => array(
    //     //                 'Claim $200 Off',
    //     //                 'Get $200 Off',
    //     //                 '$200 discount',
    //     //                 'Claim $200 discount',
    //     //                 'Get $200 cashback',
    //     //                 '$200 Off Coupon',
    //     //                 'Get Your Discount',
    //     //             ),
    //     //         ),
    //     //     ),
    //     //     'styles'        => array(
    //     //         'blue'   => array(
    //     //             'normal' => array(
    //     //                 'background-color' => '#197DFF',
    //     //                 'border-color'     => '#197DFF',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //             'hover'  => array(
    //     //                 'background-color' => '#0952B3',
    //     //                 'border-color'     => '#0952B3',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //         ),
    //     //         'yellow' => array(
    //     //             'normal' => array(
    //     //                 'background-color' => '#FF6000',
    //     //                 'border-color'     => '#FF6000',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //             'hover'  => array(
    //     //                 'background-color' => '#DE5400',
    //     //                 'border-color'     => '#DE5400',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //         ),
    //     //         'orange' => array(
    //     //             'normal' => array(
    //     //                 'background-color' => '#0952B3',
    //     //                 'border-color'     => '#0952B3',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //             'hover'  => array(
    //     //                 'background-color' => '#084596',
    //     //                 'border-color'     => '#084596',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //         ),
    //     //         'green'  => array(
    //     //             'normal' => array(
    //     //                 'background-color' => '#00FF59',
    //     //                 'border-color'     => '#00FF59',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //             'hover'  => array(
    //     //                 'background-color' => '#00B33E',
    //     //                 'border-color'     => '#00B33E',
    //     //                 'color'            => '#fff',
    //     //             ),
    //     //         ),
    //     //     ),
    //     // ),
    // ),
);
