<?php

global $CronConfigs;
$CronConfigs["murraydunngm"] = array(
    'bid' => 3.0,
    'password' => 'murraydunngm',
    'max_cost' => 0,
    "email" => "regan@smedia.ca",
    'log' => true,
    'post_code' => 'S0E 1E0',
    "lead" => array(
        'live' => false,
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
            '#002D5D',
            '#002D5D',
),
        'button_color_hover' => array(
            '#011E3D',
            '#011E3D',
),
        'button_color_active' => array(
            '#011E3D',
            '#011E3D',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 gas card coupon from Murray Dunn GM',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Murray Dunn GM Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'murray.dunn.gm.nipawin.leads@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Murray Dunn GM"></id>
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
						<name part="full">Murray Dunn GM</name>
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
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "host_url" => "http://www.murraydunngm.com",
    //must start with http or https and end without /
    "display_url" => "www.murraydunngm.com",
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
    "customer_id" => "716-925-1389",
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "murraydunngm",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",

        "fb_retargeting_description_new" => "Are you still interested in the [year] [make] [model]? 
        Sale price [price]. MSRP [msrp]. Click for more info! Stock: [stock_number]",


        "fb_lookalike_description_used" => "Check out this [year] [make] [model] today! Click for more information.",

		"fb_lookalike_description_new" => "Check out this [year] [make] [model] today! Sale price [price]. MSRP [msrp].Stock: [stock_number]",

        "fb_dynamiclead_description_new" => "Interested in the [year] [make] [model]? Sale price [price]. MSRP [msrp].Click below fill in your information. A product specialist will be in touch to answer any questions",


		"fb_dynamiclead_description_used" => "Interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#101010",
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
);