<?php

global $CronConfigs;
$CronConfigs["larsenfrederic"] = array(
    "name" => " larsenfrederic",
    "email" => "regan@smedia.ca",
    "password" => " larsenfrederic",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '259-794-9535',
    'max_cost' => 350,
    'cost_distribution' => array(
        'adwords' => 350,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
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
    "log" => true,
    "banner" => array(
        "template" => "larsenfrederic",
        "fb_description" => "Are you still interested in the [Year] [Make] [Model]? Click below for more info!",
        "fb_lookalike_description" => "Check out this [Year] [Make] [Model] today! Click for more information.",
        "fb_marketplace_title" => "[year] [make] [model] [price] [kilometres]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
),
    "lead" => array(
        'service' => array(
            'live' => true,
            'lead_type_' => false,
            'lead_type_new' => false,
            'lead_type_used' => false,
            'lead_type_service' => true,
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
                '#0062AA',
                '#0062AA',
),
            'button_color_hover' => array(
                '#353936',
                '#353936',
),
            'button_color_active' => array(
                '#353936',
                '#353936',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'We\'re Still Here & Ready to Help!',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Larsen Auto Center Team',
            'forward_to' => array(
                'marshal@smedia',
),
            'special_to' => array(
                'sales@larsenautocentersvc.dealerspace.com',
),
            'special_email' => '',
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
                'vdp' => '',
                'service' => '/(?:service|NewTires|ServiceApptForm)/',
),
),
        'new' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => false,
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
                '#0062AA',
                '#0062AA',
),
            'button_color_hover' => array(
                '#353936',
                '#353936',
),
            'button_color_active' => array(
                '#353936',
                '#353936',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => "We're Still Here & Ready to Help!",
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Larsen Auto Center Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'sales@larsenautocenter.dealerspace.com',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'lead_in' => array(
                'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
                'service' => '',
),
),
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
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
                '#0062AA',
                '#0062AA',
),
            'button_color_hover' => array(
                '#353936',
                '#353936',
),
            'button_color_active' => array(
                '#353936',
                '#353936',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => "We're Still Here & Ready to Help!",
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Larsen Auto Center Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'sales@larsenautocenter.dealerspace.com',
),
            'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Larsen Auto Center"></id>
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
						<vendorname>Larsen Auto Center</vendorname>
						<contact>
							<name part="full">Larsen Auto Center</name>
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
            'lead_in' => array(
                'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
                'service' => '',
),
),
),
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "Larsen Auto Center",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);