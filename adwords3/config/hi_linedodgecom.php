<?php

global $CronConfigs;
$CronConfigs["hi_linedodgecom"] = array(
    "name" => " hi_linedodgecom",
    "email" => "regan@smedia.ca",
    "password" => " hi_linedodgecom",
    "customer_id" => "103-482-1013",
    "log" => true,
    "banner" => array(
        "template" => "hi_linedodgecom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
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
            '#121212',
            '#121212',
),
        'button_color_hover' => array(
            '#D70910',
            '#D70910',
),
        'button_color_active' => array(
            '#D70910',
            '#D70910',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Schedule Your At-Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Tilleman Hi-Line Dodge Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'tillemanmotorco@promaxonline.net',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
					<vendorname>Tilleman Hi-Line Dodge</vendorname>
					<contact>
						<name part="full">Tilleman Hi-Line Dodge</name>
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
            'vdp' => '/\\/inventory\\/(?:new|used)-[0-9]{4}/',
            'service' => '',
),
),
    'max_cost' => 500,
    'cost_distribution' => array(
        'new' => 200,
        'dynamic' => 300,
),
);