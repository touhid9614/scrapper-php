<?php

global $CronConfigs;

$CronConfigs["covingtonhondanissan"] = array(
    'password'         => 'covingtonhondanissan',
    'email'            => 'regan@smedia.ca',
    'log'              => true,
    'lead'             => array(
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
        'sent_client_email'      => true,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#0D79B2',
            '#0D79B2',
        ),
        'button_color_hover'     => array(
            '#119FEB',
            '#13ADFF',
        ),
        'button_color_active'    => array(
            '#052D42',
            '#052D42',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Lifetime Limited Powertrain Warranty from Covington Honda Nissan',
        'response_email'         => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Covington Honda Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@covington.dsmessage.com',
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
                    <vendorname>Covington Honda</vendorname>
                    <contact>
                        <name part="full">Covington Honda</name>
                        <email>[dealer_email]</email>
                    </contact>
                </vendor>
                <provider>
                    <name part="full">sMedia</name>
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
            'vdp'           => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'banner'           => array(
        'template'                   => 'covingtonhondanissan',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_marketplace_description' => '[description]',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'adf_to'           => array(
        'leads@covington.dsmessage.com',
    ),
    'form_live'        => false,
    'buttons_live'     => false,
    'mail_retargeting' => array(
        'enabled'             => null,
        'client_id'           => '17573',
        'promotion_text'      => '',
        'promotion_color'     => '#567DC0',
        'overlay_color'       => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color'         => '#FF8500',
        'coupon_validity'     => '7',
    ),
    'name'             => 'covingtonhondanissan',
);
