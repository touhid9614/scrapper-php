<?php

global $CronConfigs;

$CronConfigs["VolvoNB"] = array(
    'password'          => 'VolvoNB',
    'email'             => 'regan@smedia.ca',
    'log'               => true,
    'adgroup_version'   => 'v10',
    'max_cost'          => 4800,
    'cost_distribution' => array(
        'adwords' => 4800,
    ),
    'customer_id'       => '765-174-5633',
    'create'            => array(
        'new_search'        => true,
        'used_search'       => true,
        'new_placement'     => true,
        'used_placement'    => true,
        'new_display'       => true,
        'used_display'      => true,
        'new_retargeting'   => true,
        'used_retargeting'  => true,
        'new_marketbuyers'  => false,
        'used_marketbuyers' => false,
        'new_combined'      => true,
        'used_combined'     => true,
    ),
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
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'banner'            => array(
        'template'                 => 'VolvoNB',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'styels'                   => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'font_color'               => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => false,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#F07F0A',
            '#F07F0A',
        ),
        'button_color_hover'     => array(
            '#126AAE',
            '#126AAE',
        ),
        'button_color_active'    => array(
            '#126AAE',
            '#126AAE',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $500 OFF coupon from Island GM',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Island GM Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@islandgm.motosnap.com',
        ),
        'special_email'          => '<?xml version="1.0"?>
            <?adf version="1.0"?>
            <adf>
                <prospect>
                    <id sequence="[total_count]" source="Volvo New Brunswick"></id>
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
                            <name part="full">Volvo New Brunswick</name>
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
        'respond_from'           => 'offers@mail.smedia.ca',
        'forward_from'           => 'offers@mail.smedia.ca',
        'thank_you'              => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in'                => array(
            'vdp'           => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'name'              => 'VolvoNB',
);