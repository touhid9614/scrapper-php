<?php

global $CronConfigs;
$CronConfigs["pinetreelincolnwoodbridge"] = array(
    "name" => " pinetreelincolnwoodbridge",
    "email" => "regan@smedia.ca",
    "password" => " pinetreelincolnwoodbridge",
    "log" => true,
    'max_cost' => 1250,
    'cost_distribution' => array(
        'adwords' => 1250,
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
    'customer_id' => '249-967-3278',
    "banner" => array(
        "template" => "pinetreelincolnwoodbridge",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => array(
        'live' => false,
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
            '#B45F1A',
            '#B45F1A',
),
        'button_color_hover' => array(
            '#FF8726',
            '#FF8726',
),
        'button_color_active' => array(
            '#3B1F08',
            '#3B1F08',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Pine Tree Lincoln Woodbridge',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Pine Tree Lincoln Woodbridge Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'smedia@pinetree-ford.net',
            'tamissy13@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Pine Tree Lincoln Woodbridge"></id>
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
					<vendorname>Pine Tree Lincoln Woodbridge</vendorname>
					<contact>
						<name part="full">Pine Tree Lincoln Woodbridge</name>
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
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|pre-owned|certified)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-[^\\.]+/',
            'service' => '',
),
),
);