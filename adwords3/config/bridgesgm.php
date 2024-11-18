<?php

global $CronConfigs;

$CronConfigs["bridgesgm"] = array(
    'name'     => 'bridgesgm',
    'email'    => 'regan@smedia.ca',
    'password' => 'bridgesgm',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log'      => true,
    'lead'     => array(
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
            '#CC9834',
            '#CC9834',
        ),
        'button_color_hover'     => array(
            '#343434',
            '#343434',
        ),
        'button_color_active'    => array(
            '#343434',
            '#343434',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $200 off! coupon from Bridges GM',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bridges GM Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
            'emil@smedia.ca',
        ),
        'special_to'             => array(
            'leads@bridgesgm.motosnap.com',
            'adf_to@smedia.ca',
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
                        <vendorname>Bridges GM</vendorname>
                        <contact>
                            <name part="full">Bridges GM</name>
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
            'vdp'           => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
            'service_regex' => '',
        ),
        'provider_name'          => 'sMedia Coupon',
    ),
    'banner'   => array(
        'template'                   => 'bridgesgm',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Test drive the [year] [make] [model] today!',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
);
