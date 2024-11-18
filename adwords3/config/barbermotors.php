<?php

global $CronConfigs;
$CronConfigs["barbermotors"] = array(
    'name'                   => 'barbermotors',
    'bid'                    => 3.0,
    'log'                    => true,
    'password'               => 'barbermotors',
    'customer_id'            => '451-710-0704',
    'bid_modifier'           => array(
        'after' => 45,
        'bid'   => 1.5,
    ),
    'max_cost'               => 1150,
    'cost_distribution'      => array(
        'new'    => 650,
        'used'   => 200,
        'custom' => 300,
    ),
    'email'                  => 'regan@smedia.ca',
    'retargetting_delay'     => 30000,
    'post_code'              => 'S4H 0N8',
    'trackers'               => array(
        'new_search'       => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search'      => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display'      => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display'     => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting'  => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined'     => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined'    => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    ),
    'lead'                   => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
        'lead_type_used'         => false,
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
            '#891C1D',
            '#891C1D',
        ),
        'button_color_hover'     => array(
            '#711314',
            '#711314',
        ),
        'button_color_active'    => array(
            '#891C1D',
            '#891C1D',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Barber Motors',
        'response_email'         => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Barber Motors Team',
        'forward_to'             => array(
            'amandagriffin@barbermotors.com',
            'andybarber@barbermotors.com',
            'marshal@smedia.ca',
            'tayler@smedia.ca',
            'salesmanager@barbermotors.com',
            'adfleads@dlsaccelerator.com',
        ),
        'special_to'             => array(),
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
            'vdp'           => '/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service_regex' => '',
        ),
    ),
    'bing_account_id'        => 156002978,
    'create'                 => array(),
    'host_url'               => 'http://www.barbermotors.com',
    'display_url'            => 'www.barbermotors.com',
    'new_descs'              => array(
        array(
            'desc' => 'Test Drive the [year]',
            'desc' => '[make] [model] today.',
        ),
        array(
            'desc' => 'Call us today about the ',
            'desc' => '[year] [make] [model]',
        ),
    ),
    'used_descs'             => array(
        array(
            'desc' => 'Test Drive the [year]',
            'desc' => '[make] [model] today.',
        ),
        array(
            'desc' => 'Call us today about the ',
            'desc' => '[year] [make] [model]',
        ),
    ),
    'options_descs'          => array(
        array(
            'desc' => 'Equipped with [option]',
            'desc' => 'and [option]',
        ),
    ),
    'ymmcount_descs'         => array(
        array(
            'desc' => 'We have [ymmcount] [make]',
            'desc' => '[model] in stock',
        ),
    ),
    'fb_brand'               => '[year] [make] [model] - [body_style]',
    'banner'                 => array(
        'template'                   => 'barbermotors',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#101010',
        'font_color'                 => '333333',
        'styels'                     => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
    ),
    'powered_by_live'        => false,
    'buttons_powered_by'     => array(
        'icon_alt'     => 'powered by smedia',
        'icon_class'   => 'powered_by_smedia',
        'icon'         => 'SMEDIA-vertical-dark.png',
        'location_tag' => '.vehicle-details > .deck [class*="vehicleGalleryDetailsAndLinks"] [class*="vehicleSpecificationsAndLogos"] > .content .link',
        'styles'       => array(
            'normal' => array(
                'background-color' => '#FFFFFF',
            ),
        ),
    ),
    'lead_to'                => array(
        'salesmanager@barbermotors.com',
        'andybarber@barbermotors.com',
        'amandagriffin@barbermotors.com',
        'internetsales@barbermotors.com',
    ),
    'button_auto_reply'      => true,
    'button_auto_reply_text' => 'Hello [first_name], We received your inquiry and will be in touch very soon.',
    'form_live'              => true,
    'buttons_live'           => true,
    'buttons'                => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
            'css-class'     => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
            'css-hover'     => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
                    'values' => array(
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
                        'Confirm Availability',
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
                        'border-color' => 'E0121',
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
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'test-drive'      => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
            'css-class'     => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
            'css-hover'     => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'test-drive' => array(
                    'target' => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
                    'values' => array(
                        'Test drive',
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today',
                        'Test Ride',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
                        'Schedule Virtual Test Drive',
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
                        'border-color' => 'E0121',
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
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'financing'       => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => array(
                'form',
                'finance',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'financing' => array(
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Estimate Payments',
                        'Financing Options',
                        'Special Finance Offers!',
                        'Calculate my Payments',
                        'Payment options',
                        'Special Finance Offers',
                        'Explore Payments',
                        'Financing Available',
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
                        'border-color' => 'E0121',
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
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
    ),
    'mail_retargeting'       => array(
        'enabled'   => null,
        'client_id' => '',
        'new'       => array(
            'promotion_text'      => '',
            'promotion_color'     => '#567DC0',
            'overlay_color'       => '#ff8500',
            'overlay_text_colour' => '#ffffff',
            'price_color'         => '#ff8500',
            'coupon_validity'     => '7',
        ),
    ),
    'adf_to'                 => '',
    'smart_memo'             => array(
        'live'                => false,
        'live_new'            => false,
        'live_used'           => false,
        'live_home'           => false,
        'live_service'        => false,
        'video'               => false,
        'video_url'           => '',
        'button_text'         => 'learn more',
        'url'                 => '',
        'home_url'            => '',
        'service_regex'       => '',
        'bg_color'            => '#EFEFEF',
        'text_color'          => '#404450',
        'border_color'        => '#E5E5E5',
        'button_text_color'   => '#FFFFFF',
        'button_color'        => array(
            '#000000',
            '#000000',
        ),
        'button_color_hover'  => array(
            '#22222',
            '#22222',
        ),
        'button_color_active' => array(
            '#22222',
            '#22222',
        ),
    ),
);