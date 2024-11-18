<?php

global $CronConfigs;
$CronConfigs["crestviewchrysler"] = array(
    'name'               => 'crestviewchrysler',
    'bid'                => 3.0,
    'log'                => true,
    'combined_feed_mode' => true,
    'password'           => 'crestviewchrysler',
    'bid_modifier'       => array(
        'after' => 45,
        'bid'   => 1.5,
    ),
    'max_cost'           => 1925,
    'cost_distribution'  => array(
        'new'     => 917,
        'used'    => 517,
        'dynamic' => 491,
    ),
    'smart_banner'       => array(
        'live'  => false,
        'title' => 'Would you like to continue shopping for',
    ),
    'email'              => 'marshal@smedia.ca',
    'bing_account_id'    => 156001388,
    'lead'               => array(
        'live'                      => false,
        'lead_type_'                => false,
        'lead_type_new'             => false,
        'lead_type_used'            => false,
        'lead_type_service'         => false,
        'shown_cap'                 => false,
        'fillup_cap'                => false,
        'session_close'             => false,
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
        'response_email_subject'    => 'Your offer from [dealership]',
        'response_email'            => '',
        'forward_to'                => array(
            'alex.roy@crestviewchrysler.ca',
            'marshal@smedia.ca',
            'marino@crestviewchrysler.ca',
            'kurtisa@crestviewchrysler.ca',
        ),
        'special_to'                => array(
            'leads@crestviewchrysler.co',
        ),
        'special_email'             => '',
        'display_after'             => 30000,
        'retarget_after'            => 5000,
        'fb_retarget_after'         => 5000,
        'adword_retarget_after'     => 5000,
        'visit_count'               => 0,
        'shown_cap_count'           => 1,
        'fillup_cap_time_days'      => 7,
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
            'vdp'           => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
            'service_regex' => '',
        ),
        'custom_div'                => '',
        'provider_name'             => 'sMedia',
        'source'                    => 'sMedia smartoffer',
    ),
    'create'             => array(),
    'post_code'          => 'S4R 2P4',
    'new_descs'          => array(
        array(
            'desc1' => '[year] [make] [model] ',
            'desc2' => 'only [Price]! Call Today',
        ),
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
        ),
        array(
            'desc1' => '[year] [make] [model] ',
            'desc2' => 'starting at *[biweekly] b/w',
        ),
    ),
    'used_descs'         => array(
        array(
            'desc1' => '[year] [make] [model] ',
            'desc2' => 'only [Price]! Call Today',
        ),
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
        ),
        array(
            'desc1' => '[year] [make] [model] ',
            'desc2' => 'starting at *[biweekly] b/w',
        ),
    ),
    'options_descs'      => array(
        array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
        ),
    ),
    'ymmcount_descs'     => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
        ),
    ),
    'customer_id'        => '430-403-1150',
    'fb_brand'           => '[year] [make] [model] - [body_style]',
    'banner'             => array(
        'template'                   => 'crestviewchrysler',
        'fb_description_new'         => 'Are you still interested in the [year] [make] [model]? Shop our inventory from the comfort of your home! Stock #: [stock_number]',
        'fb_aia_description'         => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today. Shop our inventory from the comfort of your home! Stock #: [stock_number]',
        'fb_description_used'        => 'Get Competitive Pricing on the [year] [make] [model] today. Shop our inventory from the comfort of your home!  Stock #: [stock_number]',
        'fb_marketplace_description' => '[description]',
        'fb_marketplace_title'       => '[year] [make] [model] [trim]',
        'old_price_new'              => 'msrp',
        'flash_style'                => 'default',
        'border_color'               => '#00000',
        'styels'                     => array(
            'new_display'      => 'custom_banner',
            'used_display'     => 'custom_banner',
            'new_retargeting'  => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_combined'     => 'custom_banner',
            'used_combined'    => 'custom_banner',
        ),
        'font_color'                 => '#ffffff',
    ),
    'adf_to'             => array(
        'crestviewcdjr@dealer.calldrip.com',
        'leads@crestviewchrysler.co',
    ),
    'lead_to'            => array(
        'kurtisa@crestviewchrysler.ca',
        'alex.roy@crestviewchrysler.ca',
        'james.mcdonough@crestviewchrysler.ca',
        'marino@crestviewchrysler.ca',
    ),
    'form_live'          => true,
    'buttons_live'       => true,
    'button_algorithm'   => 'thompson_sampling|softmax|ucb-1|default',
    'buttons'            => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/inventory\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
            'css-class'     => 'a.button.cta-button.block.button-form.fancybox',
            'css-hover'     => 'a.button.cta-button.block.button-form.fancybox:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'a.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Confirm Availability',
                        'You are Eligible for Special Pricing',
                        'Special Pricing!',
                        'Request A Quote',
                        'Get Our Best Price',
                        'Get E Price Now!',
                        'Get Internet Price Now!',
                        'Exclusive Price',
                        'Get Your Exclusive Price',
                        'Best Price',
                        'Calculate Payments',
                        'Estimate Payments',
                        'More Information',
                        'More Info',
                        'Test Drive From Home',
                    ),
                ),
            ),
            'styles'        => array(
                'orange'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red'      => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CE)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
    ),
);