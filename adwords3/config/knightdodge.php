<?php

global $CronConfigs;
$CronConfigs["knightdodge"] = array(
    'name' => 'Knight Dodge',
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'password' => 'knightdodge',
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 337.5,
    'cost_distribution' => array(
        'used' => 287.5,
        'new' => 50,
),
    'bing_account_id' => 156002891,
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'retargetting_delay' => 30000,
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
            '#EF4227',
            '#EF4227',
),
        'button_color_hover' => array(
            '#86281A',
            '#86281A',
),
        'button_color_active' => array(
            '#86281A',
            '#86281A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Request a Video Walk-Around of your vehicle of interest',
        'response_email' => 'Hello [name],<p> Thank you for signing up for this offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Knight Dodge Team',
        'forward_to' => array(
            'mikeerdahl@knightdodge.com',
            'billjasper@knightdodge.com',
            'shaun@knightdodge.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@knightdodge.co',
),
        'special_email' => '<?xml version="1.0" encoding="UTF-8"?>
                                    <?adf version="1.0"?>
                                    <adf>
                                        <prospect>
                                            <id sequence="[total_count]" source="Knight Dodge"></id>
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
                                                    <name part="full">Knight Dodge</name>
                                                    <email>[dealer_email]</email>
                                                </contact>
                                            </vendor>
                                            <provider>
                                                <name part="full">sMedia</name>
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
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)-[0-9]{4}-/i',
            'service' => '',
),
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_combined" => yes,
        "new_combined" => yes,
),
    "post_code" => "s9h 0b5",
    //Max lenght 35 char
    "new_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    "customer_id" => "334-112-9298",
    "banner" => array(
        "template" => "knightdodge",
        'fb_description_new' => 'Are you still interested in the [year] [make] [model]? Shop our inventory from the comfort of your home! Stock #: [stock_number]',
        'fb_description_used' => 'Get Competitive Pricing on the [year] [make] [model] today! Shop our inventory from the comfort of your home! Stock #: [stock_number]',
        "fb_lookalike_description" => "Check out this [year] [make] [model] today. Shop our inventory from the comfort of your home! Stock #: [stock_number]",
		"fb_dynamiclead_description"	=> "Are you still interested in this [year] [make] [model]? Shop from the comfort of your home! Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "fb_marketplace_description" => "[description]",
        "fb_marketplace_title" => "[year] [make] [model] [trim]",
        "flash_style" => "default",
        "border_color" => "#000",
        "old_price" => "msrp",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    'adf_to' => [
        'leads@knightdodge.co',
],
    'form_live' => false,
);