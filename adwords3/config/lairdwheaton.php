<?php

global $CronConfigs;
$CronConfigs["lairdwheaton"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'combined_feed_mode' => true,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'password' => 'lairdwheaton',
    'max_cost' => 2080,
    'cost_distribution' => array(
        'new' => 1352,
        'used' => 624,
        'youtube' => 104,
),
    "email" => "regan@smedia.ca",
    'post_code' => 'V9T 3L3',
    //tracker
    "create" => array(
        "special_search" => yes,
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "host_url" => "http://www.lairdwheaton.com",
    //must start with http or https and end without /
    "display_url" => "www.lairdwheaton.com",
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
    "special_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    "customer_id" => "117-841-6523",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "email" => "regan@smedia.ca",
    "banner" => array(
        "template" => "lairdwheaton",
        "fb_retargeting_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today. Click for more information.",
        "fb_agedstock_description" => "Get your best deal on this [year] [make] [model]. Blowout pricing! Bank rate financing! Best deals in BC! Shop now.",
        "fb_dynamiclead_description" => "Check out this [year] [make] [model] today! Click below and fill in your information. A product specialist will be in touch to answer any question.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0061B3',
            '#0061B3',
),
        'button_color_hover' => array(
            '#005499',
            '#005499',
),
        'button_color_active' => array(
            '#005499',
            '#005499',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 off coupon from Laird Wheaton GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Laird Wheaton GM Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'webleads@lairdwheatongm.dsmessage.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Laird Wheaton GM"></id>
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
						<name part="full">Laird Wheaton GM</name>
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
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
),
);