<?php

global $CronConfigs;
$CronConfigs["mannnorthway"] = array(
    "name" => " mannnorthway",
    "email" => "regan@smedia.ca",
    "password" => " mannnorthway",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => true,
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
            '#0066CB',
            '#0066CB',
),
        'button_color_hover' => array(
            '#616F78',
            '#616F78',
),
        'button_color_active' => array(
            '#616F78',
            '#616F78',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Mann Northway',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Mann Northway Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'emil@smedia.ca',
),
        'special_to' => array(
            'leads@Mann.motosnap.com',
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
						<contact>
							<name part="full">Mann Northway</name>
							<email>[dealer_email]</email>
						</contact>
					</vendor>
					<provider>
						<name part="full">sMedia Coupon</name>
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
    "banner" => array(
        "template" => "mannnorthway",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? You may qualify for an extra bonus, click below and fill in your info to claim it.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);