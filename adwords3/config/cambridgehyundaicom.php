<?php

global $CronConfigs;

$CronConfigs["cambridgehyundaicom"] = array(
    'name'               => 'cambridgehyundaicom',
    'email'              => 'regan@smedia.ca',
    'password'           => 'cambridgehyundaicom',
    'log'                => true,
    'combined_feed_mode' => true,
    'lead'               => array(
        'live'                   => true,
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
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#0A2972',
            '#0A2972',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#25448D',
            '#25448D',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Claim $200 Off with a purchase from Cambridge Hyundai',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Cambridge Hyundai Team',
        'forward_to'             => array(
            '',
        ),
        'special_to'             => array(
            'leads@Cambridgehyundai.motosnap.com',
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
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
        ),
        'custom_div'             => '',
    ),
);
