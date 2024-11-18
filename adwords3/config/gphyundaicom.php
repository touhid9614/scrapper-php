<?php

global $CronConfigs;
$CronConfigs["gphyundaicom"] = array(
    'name' => 'gphyundaicom',
    'email' => 'regan@smedia.ca',
    'password' => 'gphyundaicom',
    'log' => true,
    'lead' => array(
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'inactivity' => true,
            'exit_intent' => true,
            'session_depth' => false,
            'campaign_cap_google' => false,
            'campaign_cap_fb' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#000000',
                '#000000',
),
            'button_color_hover' => array(
                '#222222',
                '#222222',
),
            'button_color_active' => array(
                '#222222',
                '#222222',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => 'Your offer from [dealership]',
            'response_email' => '',
            'forward_to' => array(
                '',
),
            'special_to' => array(
                '',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'shown_cap_count' => 1,
            'fillup_cap_time_days' => 7,
            'session_close_cap' => 3,
            'inactivity_timeout' => 600000,
            'exit_intent_timeout' => 10000,
            'session_depth_page' => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days' => 7,
            'campaign_fb_cap_count' => 3,
            'campaign_fb_cap_days' => 7,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
        'new' => array(
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
            'sent_client_email' => false,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#002C5F',
                '#002C5F',
),
            'button_color_hover' => array(
                '#000000',
                '#000000',
),
            'button_color_active' => array(
                '#000000',
                '#000000',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Claim $200 off coupon from Grande Prairie Hyundai',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Grande Prairie Hyundai Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'leads@grandeprairiehyundai.motosnap.com',
                'tamissy13@gmail.com',
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
                        <vendorname>Grande Prairie Hyundai</vendorname>
                        <contact>
                            <name part="full">Grande Prairie Hyundai</name>
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
            'display_after' => 25000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
),
),
);