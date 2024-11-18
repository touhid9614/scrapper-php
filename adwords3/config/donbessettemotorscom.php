<?php

global $CronConfigs;
$CronConfigs["donbessettemotorscom"] = array(
    "name" => " donbessettemotorscom",
    "email" => "regan@smedia.ca",
    "password" => " donbessettemotorscom",
	// "no_adv" => log,	// This has crashed a few codes
	"log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "donbessettemotorscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
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
            '#035892',
            '#035892',
),
        'button_color_hover' => array(
            '#65B6EE',
            '#65B6EE',
),
        'button_color_active' => array(
            '#04243A',
            '#04243A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Sign Up For FREE At-Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Don Bessette Auto Group',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@donbessettemotors.net',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Don Bessette Auto Group"></id>
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
						<vendorname>Don Bessette Auto Group</vendorname>
						<contact>
							<name part="full">Don Bessette Auto Group</name>
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
            'vdp' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
);