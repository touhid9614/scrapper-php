<?php

global $CronConfigs;

$CronConfigs["bannisters"] = array(
    'name'              => 'bannisters',
    'email'             => 'regan@smedia.ca',
    'password'          => 'bannisters',
    'log'               => true,
    'max_cost'          => 1600,
    'cost_distribution' => array(
        'adwords' => 1600,
    ),
    'create'            => array(),
    'new_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
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
    'customer_id'       => '859-937-1576',
    'banner'            => array(
        'template'                   => 'bannisters',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to get our best price.',
        'hst'                        => true,
        'flash_style'                => 'default',
        'styels'                     => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
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
        'sent_client_email'      => true,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#EB242E',
            '#EB242E',
        ),
        'button_color_hover'     => array(
            '#9C1519',
            '#9C1519',
        ),
        'button_color_active'    => array(
            '#9C1519',
            '#9C1519',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Claim an extra $200 off coupon from Bannister GM Vernon',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bannister GM Vernon Team',
        'forward_to'             => array(
            'seanm@bannisters.com',
            'sales@bannisters.com',
            'marshal@smedia.ca'
        ),
        'special_to'             => array(
            'cdkileads@bannisters.com',
            'adf_to@smedia.ca',
            'leads@bannistergmvernon.ca'
        ),
        'special_email'          => '<?xml version="1.0"?>
        <?adf version="1.0"?>
        <adf>
            <prospect>
                <id sequence="[total_count]" source="Bannister Vernon GM"></id>
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
                        <name part="full">Bannister Vernon GM</name>
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
            'vdp'           => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
        'custom_div'             => '',
    ),
);