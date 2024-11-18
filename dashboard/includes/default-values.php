<?php

$smart_memo_default = [
    'live'                => false,
    'live_new'            => false,
    'live_used'           => false,
    'live_home'           => false,
    'live_service'        => false,
    'video'               => false,
    'hide_redirection'    => false,
    'video_url'           => '',
    'button_text'         => 'learn more',
    'url'                 => '',
    'home_url'            => '',
    'service_regex'       => '',
    'bg_color'            => '#EFEFEF',
    'text_color'          => '#404450',
    'border_color'        => '#E5E5E5',
    'button_text_color'   => '#FFFFFF',
    'button_color'        => ['#000000', '#000000'],
    'button_color_hover'  => ['#222222', '#222222'],
    'button_color_active' => ['#222222', '#222222'],
];

$smart_offer_default = [
    'live'                      => false,
    'lead_type_'                => false,
    'lead_type_new'             => false,
    'lead_type_used'            => false,
    'lead_type_service'         => false,
    'shown_cap'                 => false,
    'fillup_cap'                => false,
    'session_close'             => false,
    'inactivity'                => true, // new  // done
    'exit_intent'               => true, // new  // done
    'session_depth'             => false, // new
    'campaign_cap_google'       => false, // new  // done
    'campaign_cap_fb'           => false, // new  // done
    'device_type'               => [
        'desktop' => true,
        'tablet'  => true,
        'mobile'  => true,
    ],
    'sent_client_email'         => true,
    'offer_minimum_price'       => 0,
    'offer_maximum_price'       => 10000000,
    'bg_color'                  => '#EFEFEF',
    'text_color'                => '#404450',
    'border_color'              => '#E5E5E5',
    'button_color'              => ['#000000', '#000000'],
    'button_color_hover'        => ['#222222', '#222222'],
    'button_color_active'       => ['#222222', '#222222'],
    'button_text_color'         => '#FFFFFF',
    'forward_email_subject'     => "#[monthly_count] Smedia Coupon Lead.",
    'response_email_subject'    => "Your offer from [dealership]",
    'response_email'            => '',
    'forward_to'                => [''],
    'special_to'                => [''],
    'special_email'             => '',
    'display_after'             => 30000,
    'retarget_after'            => 5000,
    'fb_retarget_after'         => 5000,
    'adword_retarget_after'     => 5000,
    'visit_count'               => 0,
    'shown_cap_count'           => 1, // new  // done
    'fillup_cap_time_days'      => 7, // new  // done
    'session_close_cap'         => 3, // new  // done
    'inactivity_timeout'        => 600000, // new  // done
    'exit_intent_timeout'       => 10000, // new  // done
    'session_depth_page'        => 0, // new
    'campaign_google_cap_count' => 3, // new  // done
    'campaign_google_cap_days'  => 7, // new  // done
    'campaign_fb_cap_count'     => 3, // new  // done
    'campaign_fb_cap_days'      => 7, // new  // done
    'video_smart_offer'         => false,
    'video_smart_offer_form'    => false,
    'video_url'                 => '',
    'video_title'               => '',
    'video_description'         => '',
    'lead_in'                   => [],
    'custom_div'                => '',
    'provider_name'             => 'sMedia', // sMedia / sMedia Coupon
    'source'                    => 'sMedia smartoffer',
    'button_text'               => 'submit',
];

$vinnauto_default = [
    'button_status'       => false,
    'button_debug'        => false,
    'dealership_id'       => '',
    'VINN_SIGNING_SECRET' => 'adslfkjasldfjk',
    'button_position'     => 'afterend',
    'button_container'    => '',
    'button_code'         => '',
    'button_text'         => 'CHECKOUT',
];

$default_tag_controls = [
    'event_tracker' => true,
];