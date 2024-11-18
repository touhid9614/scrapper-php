<?php

global $CronConfigs;
$CronConfigs["fortmyersmitsubishi"] = array(
    'password' => 'fortmyersmitsubishi',
    "email" => "regan@smedia.ca",
    'log' => true,
    'bing_account_id' => 156002961,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '157-509-1231',
/*    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
            '#E70017',
            '#E70017',
),
        'button_color_hover' => array(
            '#A90D1B',
            '#A90D1B',
),
        'button_color_active' => array(
            '#A90D1B',
            '#A90D1B',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 off with this offer from FORT MYERS MITSUBISHI. ',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>FORT MYERS MITSUBISHI',
        'forward_to' => array(
            'amathalia@floridamitsu.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@fortmyersmitsu.motosnap.com',
),
        'special_email' => '<?xml version="1.0" encoding="UTF-8"?>
                                    <?adf version="1.0"?>
                                    <adf>
                                        <prospect>
                                            <id sequence="[total_count]" source="Fort Myers Mitsubishi"></id>
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
                                                    <name part="full">Fort Myers Mitsubishi</name>
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
),*/
    "banner" => array(
        "template" => "fortmyersmitsubishi",
        "fb_description_new" => "Are you still interested in the [year] [make] [model]? Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!",
        "fb_description_used" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] today! Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!",
        "fb_lookalike_description_used" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
);