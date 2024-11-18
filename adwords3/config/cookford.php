<?php

global $CronConfigs;

$CronConfigs["cookford"] = array(
    'bid'               => 3.0,
    'log'               => true,
    'password'          => 'cookford',
    'post_code'         => 'N8M 2C8',
    'email'             => 'regan@smedia.ca',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'customer_id'       => '721-007-3127',
    'banner'            => array(
        'template'                   => 'cookford',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to secure your bottom line price.',
        'flash_style'                => 'default',
        'hst'                        => true,
        'border_color'               => '#282828',
        'styels'                     => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
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
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#2A8BBE',
            '#2A8BBE',
        ),
        'button_color_hover'     => array(
            '#004286',
            '#004286',
        ),
        'button_color_active'    => array(
            '#004286',
            '#004286',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Cook County Ford will buy your car!',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Cook County Ford Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'webleads@cookcountyford.dsmessage.com',
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
                    <vendorname>Cook County Ford</vendorname>
                    <contact>
                        <name part="full">Cook County Ford</name>
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
            'vdp'           => '/\\/(?:new|used)-[^-]+-[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'adf_to'            => array(
        'cookcountyford@eleadtrack.net',
    ),
    'form_live'         => false,
    'buttons_live'      => false,
    'mail_retargeting'  => array(
        'enabled'             => true,
        'client_id'           => '17570',
        'promotion_text'      => '',
        'promotion_color'     => '#567DC0',
        'overlay_color'       => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color'         => '#FF8500',
        'coupon_validity'     => '7',
    ),
    'max_cost'          => 260,
    'cost_distribution' => array(),
    'name'              => 'cookford',
);
