<?php

global $CronConfigs;
$CronConfigs["woodwheatonhonda"] = array(
    "name" => " woodwheatonhonda",
    "email" => "regan@smedia.ca",
    "password" => " woodwheatonhonda",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    //budget updated
    'max_cost' => 250,
    'cost_distribution' => array(
        'adwords' => 250,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
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
    "customer_id" => "320-502-6837",
    "banner" => array(
        "template" => "woodwheatonhonda",
        "fb_marketplace_description" => "[description]",
         'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
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
            '#CB0E1A',
            '#CB0E1A',
),
        'button_color_hover' => array(
            '#BA0611',
            '#BA0611',
),
        'button_color_active' => array(
            '#BA0611',
            '#BA0611',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $250 gas card from Wood Wheaton Honda',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Wood Wheaton Honda Team',
        'forward_to' => array(
            'dsmith@woodwheatonhonda.ca',
            'gfoulds@woodwheatonhonda.ca',
            'bparker@woodwheaton.com',
            'taya@woodwheatonhonda.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'woodwheatonhonda@newsales.leads.cmdlr.com',
            'woodwheatonhondaleads@tmscan.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Wood Wheaton Honda"></id>
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
					<vendorname>Wood Wheaton Honda</vendorname>
					<contact>
						<name part="full">Wood Wheaton Honda</name>
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
        'display_after' => 15000,
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
            'vdp' => '/\\/(?:new|used|certified)\\/+[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
);