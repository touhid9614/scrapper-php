<?php

global $CronConfigs;
$CronConfigs["smpchev"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'password' => 'smpchev',
    'post_code' => 'S7K 0V1',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#126AAE',
            '#126AAE',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Saskatoon Motor Products',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Saskatoon Motor Products Team',
        'forward_to' => array(
            'kpaulsen@smpchev.ca',
            'bsnowsell@smpchev.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@Saskatoon.motosnap.com ',
),
        'special_email' => '<?xml version="1.0"?>
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
                    <name part="full">Saskatoon Motor Products</name>
                    <email>[dealer_email]</email>
                </contact>
            </vendor>
            <provider>
                <name part="full">sMedia Coupon</name>
                <url>http://smedia.ca</url>
                <email>offers@mail.smedia.ca</email>
                <phone>855-775-0062</phone>
            </provider>
        </prospect>
    </adf>',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service' => '',
),
),
    "banner" => array(
        "template" => "smpchev",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info to get \$200 OFF, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#ffffff",
),
);