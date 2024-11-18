<?php

global $CronConfigs;
$CronConfigs["joecottonfordcom"] = array(
    "name" => " joecottonfordcom",
    "email" => "regan@smedia.ca",
    "password" => " joecottonfordcom",
    "customer_id" => "592-032-9676",
    "log" => true,
    "banner" => array(
        "template" => "joecottonfordcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => false,
            'desktop' => false,
            'tablet' => false,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#003478',
            '#003478',
),
        'button_color_hover' => array(
            '#001A3C',
            '#001A3C',
),
        'button_color_active' => array(
            '#001A3C',
            '#001A3C',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Schedule Free At-Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Joe Cotton Ford Team',
        'forward_to' => array(
            'jwolfe@joecottonford.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@jcfordcs.com',
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
					<vendorname>Joe Cotton Ford</vendorname>
					<contact>
						<name part="full">Joe Cotton Ford</name>
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
            'vdp' => '',
            'service' => '',
),
),
    'max_cost' => 714,
    'cost_distribution' => array(
        'new' => 357,
        'used' => 357,
),
);