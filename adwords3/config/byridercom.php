<?php

global $CronConfigs;

$CronConfigs["byridercom"] = array(
    'name'     => 'byridercom',
    'email'    => 'regan@smedia.ca',
    'password' => 'byridercom',
    'log'      => true,
    'lead'     => array(
        'used' => array(
            'live'                   => true,
            'lead_type_'             => true,
            'lead_type_new'          => false,
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
            'sent_client_email'      => true,
            'offer_minimum_price'    => 0,
            'offer_maximum_price'    => 10000000,
            'bg_color'               => '#EFEFEF',
            'text_color'             => '#404450',
            'border_color'           => '#E5E5E5',
            'button_color'           => array(
                '#0C12B9',
                '#0C12B9',
            ),
            'button_color_hover'     => array(
                '#0700FF',
                '#0700FF',
            ),
            'button_color_active'    => array(
                '#0C12B9',
                '#0C12B9',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => '',
            'response_email'         => '',
            'forward_to'             => array(
                'kzalaznik@hoffman-development.com',
                'jfreund@byrider.com',
            ),
            'special_to'             => array(
                'kzalaznik@hoffman-development.com',
                'jfreund@byrider.com',
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
                'vdp'           => '/\\/inventory\\/[0-9]{4}-/i',
                'service_regex' => '',
            ),
            'custom_div'             => '<strong>Consent for contact:</strong> I read this E-SIGN consent and agree to it\'s terms. By clicking "Submit", I consent to be contacted via email, text or phone including by auto dialer and/or pre-recorded message by Byrider or it\'s affiliates. I am not required to give this authorization as a condition of any purchase.',
        ),
    ),
);
