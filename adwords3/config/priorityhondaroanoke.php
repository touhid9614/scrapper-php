<?php

global $CronConfigs;
$CronConfigs["priorityhondaroanoke"] = array(
    "name" => " priorityhondaroanoke",
    "email" => "regan@smedia.ca",
    "password" => " priorityhondaroanoke",
    "log" => true,
    "banner" => array(
        "template" => "priorityhondaroanoke",
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
            '#007CC2',
            '#007CC2',
),
        'button_color_hover' => array(
            '#004166',
            '#004166',
),
        'button_color_active' => array(
            '#004166',
            '#004166',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 off coupon from Priority Honda Roanoke',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Priority Honda Roanoke Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'sales@priorityhondaroanoke.edealerhub.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Priority Honda Roanoke"></id>
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
						<name part="full">Priority Honda Roanoke</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia Smart Offer</name>
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