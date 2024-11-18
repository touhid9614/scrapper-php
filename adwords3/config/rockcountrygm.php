<?php

global $CronConfigs;
$CronConfigs["rockcountrygm"] = array(
    'password' => 'rockcountrygm',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "customer_id" => "402-168-6552",
    /* ===smart offer=== */
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
            '#2DC315',
            '#2DC315',
),
        'button_color_hover' => array(
            '#29B814',
            '#29B814',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $250 bonus on your vehicle purchase',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Rock Country GM Team',
        'forward_to' => array(
            'darrick@rockcountrygm.ca',
            'marshal@smedia.ca',
            'brad@rockcountrygm.ca',
            'brynn@rockcountrygm.ca',
),
        'special_to' => array(
            'rockcountrygm1@pbssystems.com',
            'Leads@rockcountrygm.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Rock Country GM"></id>
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
						<name part="full">Rock Country GM</name>
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
    /* ===dynamic social ads=== */
    "banner" => array(
        "template" => "rockcountrygm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "fb_polk_description" => "Test drive the [year] [make] [model] today!",
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
    'customer_id' => '402-168-6552',
    'max_cost' => 1500,
    'cost_distribution' => array(
        'adwords' => 1500,
),
    "create" => array(
        "new_display" => yes,
        "new_combined" => yes,
        "new_retargeting" => yes,
        "new_search" => yes,
        "used_combined" => yes,
        "used_placement" => yes,
        "used_display" => yes,
        "used_retargeting" => yes,
        "used_search" => yes,
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
            "desc2" => "[year] [make] [model] today",
),
),
);