<?php

global $CronConfigs;

$CronConfigs["arlingtonacura"] = array(
    'password' => 'arlingtonacura',
    'email'    => 'regan@smedia.ca',
    'log'      => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner'   => array(
        'template'                 => 'arlingtonacura',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'lead'     => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
        'lead_type_used'         => false,
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
            '#333232',
            '#333232',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#000000',
            '#000000',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Special offer from Arlington Acura',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Arlington Acura Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@arlingtonacura.com',
        ),
        'special_email'          => '<?xml version="1.0"?>
        <?adf version="1.0"?>
        <adf>
            <prospect>
                <id sequence="[total_count]" source="Arlington Acura"></id>
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
                        <name part="full">Arlington Acura</name>
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
        'lead_in'                => array(
            'vdp'           => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'name'     => 'arlingtonacura',
);