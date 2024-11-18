<?php

global $CronConfigs;
$CronConfigs["murraybrandongm"] = array(
    'name' => 'Murray Brandon GM',
    //'budget'    => 2.0,
    'password' => 'murraybrandongm',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 0.0,
    'cost_distribution' => array(
        'youtube' => 0.0,
),
    'log' => true,
    'post_code' => 'R7A 7E3',
    "email" => "regan@smedia.ca",
    //tracker
    'perfect_audience_id' => '54f09151699538880b000061',
    "trackers" => array(
        "new_search" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_search" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_display" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_display" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_retargeting" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_retargeting" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "new_combined" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
        "used_combined" => "utm_source=smedia&utm_medium=google&utm_campaign=inventory",
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "smart_ad_url" => "http://www.murraychevbrandon.com/all-inventory/index.htm?model=[model]&year=[year]&make=[make]",
    "host_url" => "http://www.murraychevbrandon.com",
    //must start with http or https and end without /
    "display_url" => "www.murraychevbrandon.com",
    //Max lenght 35 char
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "customer_id" => "814-716-7314",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "murraybrandongm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#dfdfdf",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
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
            '#0060AA',
            '#0060AA',
),
        'button_color_hover' => array(
            '#002D4F',
            '#002D4F',
),
        'button_color_active' => array(
            '#002D4F',
            '#002D4F',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '2 FREE Oil Package from Murray Brandon GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Murray Brandon GM Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'murray.gm.brandon.leads@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
					<?adf version="1.0"?>
					<adf>
						<prospect>
							<id sequence="[total_count]" source="Murray Brandon GM"></id>
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
									<name part="full">Murray Brandon GM</name>
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
),
);