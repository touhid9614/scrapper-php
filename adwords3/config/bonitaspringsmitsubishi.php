<?php

global $CronConfigs;
$CronConfigs["bonitaspringsmitsubishi"] = array(
    "name" => " bonitaspringsmitsubishi",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "email" => "regan@smedia.ca",
    "password" => " bonitaspringsmitsubishi",
    'log' => true,
    'bing_account_id' => 156002960,
    'max_cost' => 0,
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
    'customer_id' => '935-051-1225',
    "banner" => array(
        "template" => "bonitaspringsmitsubishi",
        "fb_description_new" => "Are you still interested in the [year] [make] [model]? Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!",
        "fb_description_used" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] today! Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!",
        "fb_lookalike_description_used" => "Check out this [year] [make] [model] today! Click for more information.",
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
    /*smart offer*/
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
        'response_email_subject' => '$200 OFF from Bonita Springs Mitsubishi',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bonita Springs Mitsubishi Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@bonitaspringsmitsubishi.com',
),
        'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Bonita Springs Mitsubishi"></id>
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
					<name part="full">Bonita Springs Mitsubishi</name>
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17567',
        'promotion_text' => 'CLAIM $200 OFF!',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#CD3134',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#CD3134',
        'coupon_validity' => '30',
),
);