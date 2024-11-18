<?php

global $CronConfigs;

$CronConfigs["abbotsfordvw"] = array(
    'name'              => 'abbotsfordvw',
    'email'             => 'regan@smedia.ca',
    'password'          => 'abbotsfordvw',
    'log'               => true,
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'max_cost'          => 800,
    'cost_distribution' => array(
        'adwords' => 800,
    ),
    'create'            => array(),
    'new_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'customer_id'       => '206-759-1830',
    'banner'            => array(
        'template'                   => 'abbotsfordvw',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'styels'                     => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'lead_type_service'      => true,
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
            '#0070BB',
            '#0070BB',
        ),
        'button_color_hover'     => array(
            '#003D66',
            '#003D66',
        ),
        'button_color_active'    => array(
            '#003D66',
            '#003D66',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $250 off your vehicle purchase at Abbotsford Volkswagen',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Abbotsford VW Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@abbotsfordvw.motosnap.com',
        ),
        'special_email'          => '<?xml version="1.0"?>
        <?adf version="1.0"?>
        <adf>
            <prospect>
                <id sequence="[total_count]" source="sMedia Coupon"></id>
                <requestdate>[fdt]</requestdate>
                <vehicle interest="buy" status="[stock_type]">
                    <year>[year]</year>
                    <make>[make]</make>
                    <model>[model]</model>
                    <stock>[stock_number]</stock>
                </vehicle>
                <customer>
                   <contact>
                        <name part="full">[name]</name>
                        <email>[email]</email>
                        <phone>[phone]</phone>
                    </contact>
                </customer>
                <vendor>
                    <contact>
                        <name part="full">Abbotsford Volkswagen Team</name>
                        <email>[dealer_email]</email>
                    </contact>
                </vendor>
                <provider>
                    <name part="full">sMedia Coupon</name>
                    <url>https://smedia.ca</url>
                    <email>offers@mail.smedia.ca</email>
                    <phone>855-775-0062</phone>
                </provider>
            </prospect>
        </adf>',
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
            'vdp'           => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service_regex' => '',
        ),
        'custom_div'             => '',
        'provider_name'          => 'sMedia Coupon',
    ),
);
