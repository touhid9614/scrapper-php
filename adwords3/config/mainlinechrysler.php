<?php

global $CronConfigs;
$CronConfigs["mainlinechrysler"] = array(
    'name' => 'mainlinechrysler',
    'log' => true,
    'combined_feed_mode' => true,
    'password' => 'mainlinechrysler',
    'bid' => 3.0,
    'bing_account_id' => 156002886,
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'max_cost' => 1470,
    'cost_distribution' => array(),
    'post_code' => 'S0L 2V0',
    'email' => 'regan@smedia.ca',
    'trackers' => array(
        'new_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'King of Trucks. Call about',
            'desc2' => 'the [year] [make] [model].',
),
        array(
            'desc1' => 'King of Trucks. Test Drive',
            'desc2' => 'The [make] [model]',
),
        array(
            'desc1' => 'King of Trucks. Test Drive',
            'desc2' => 'The [year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'King of Trucks. Call about',
            'desc2' => 'the [year] [make] [model].',
),
        array(
            'desc1' => 'King of Trucks. Test Drive',
            'desc2' => 'The [make] [model]',
),
        array(
            'desc1' => 'King of Trucks. Test Drive',
            'desc2' => 'The [year] [make] [model]',
),
),
    'options_descs' => array(
        array(
            'orange' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#F04713,#F04713)',
                    'border-color' => 'F06B20',
),
                'hover' => array(
                    'background' => 'linear-gradient(#CF540E,#CF540E)',
                    'border-color' => 'CF540E',
),
),
            'green' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#408C31,#408C31)',
                    'border-color' => '54B740',
),
                'hover' => array(
                    'background' => 'linear-gradient(#359D22,#359D22)',
                    'border-color' => '359D22',
),
),
            'yellow' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#EECE30,#EECE30)',
                    'border-color' => 'EED353',
),
                'hover' => array(
                    'background' => 'linear-gradient(#EBCB34,#EBCB34)',
                    'border-color' => 'EBCB34',
),
),
            'Cyan' => array(
                'normal' => array(
                    'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                    'border-color' => 'EED353',
),
                'hover' => array(
                    'background' => 'linear-gradient(#0093CF,#0093CF)',
                    'border-color' => 'EBCB34',
),
),
),
),
    'ymmcount_descs' => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'customer_id' => '242-392-2065',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'mainlinechrysler',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more info!',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#161616',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
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
            '#004A8A',
            '#004A8A',
),
        'button_color_hover' => array(
            '#002F57',
            '#002F57',
),
        'button_color_active' => array(
            '#002F57',
            '#002F57',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => '$500 off coupon from Mainline Chrysler',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"><p><br><br>Mainline Chrysler Team',
        'forward_to' => array(
            'achoumont@mainlinechrysler.ca',
            'kherbert@mainlinechrysler.ca',
            'Kmcavoy@mainlinechrysler.ca',
            'marshal@smedia.ca',
            'dguinan@mainlinechrysler.ca',
            'kknox@mainlinechrysler.ca',
),
        'special_to' => array(
            'mainlinec.smedia@quickestreply.com',
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
                    <vendorname>Mainline Chrysler Dodge Jeep Ram</vendorname>
                    <contact>
                        <name part="full">Mainline Chrysler Dodge Jeep Ram</name>
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
            'vdp' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'phone_domelement' => 'document.getElementById("header_tollfree")',
    'phone_regex' => '/[0-9]\\-[0-9]{3}\\-[0-9]{3}\\-[0-9]{4}/',
    'lead_to' => array(
        'rcarruthers@mainlinechrysler.ca',
        'rbayda@mainlinechrysler.ca',
        'kherbert@mainlinechrysler.ca',
        'kknox@mainlinechrysler.ca',
        'achoumont@mainlinechrysler.ca',
),
    'adf_to' => array(
        'mainlinec.smedia@quickestreply.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href="#modal__gform_10"]',
            'css-class' => 'a[href="#modal__gform_10"]',
            'css-hover' => 'a[href="#modal__gform_10"]:hover',
            'button_action' => array(
                'form',
                'e-price-mainlinechrysler',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href="#modal__gform_10"]',
                    'values' => array(
                        'Check Availability',
                        'Confirm Availability',
                        'Ask for Availability',
                        'Check Availability',
                        'Is This Available?',
                        'Ask For Availability',
                        'Ask For Availability',
                        'Send Message',
                        'Special Pricing!',
                        'Ask Availability',
                        'Check Availability',
                        'Get Availability',
                        'Get Availability',
                        'Get Your e-Price',
                        'Inquire Now!',
                        'Submit Request',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F04713,#F04713)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#408C31,#408C31)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EECE30,#EECE30)',
                        'border-color' => 'EED353',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#EBCB34,#EBCB34)',
                        'border-color' => 'EBCB34',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => 'EED353',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => 'EBCB34',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a.main-cta-button.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-class' => 'a.main-cta-button.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-hover' => 'a.main-cta-button.di-modal.main-cta.vdp-pricebox-cta-button:hover',
            'button_action' => array(
                'form',
                'finance-mainlinechrysler',
),
            'sizes' => array(
                array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a.main-cta-button.di-modal.main-cta.vdp-pricebox-cta-button',
                    'values' => array(
                        'Explore Payments',
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Explore Payments',
                        'Financing Options',
                        'Get a Quote',
                        'Get Internet Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Get Your Best Price',
                        'Payment Options',
                        'Request a Quote',
                        'Special Finance Offers!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F04713,#F04713)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#408C31,#408C31)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EECE30,#EECE30)',
                        'border-color' => 'EED353',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#EBCB34,#EBCB34)',
                        'border-color' => 'EBCB34',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => 'EED353',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => 'EBCB34',
),
),
),
),
),
);