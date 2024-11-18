<?php

global $CronConfigs;
$CronConfigs["royfossthornhill"] = array(
    'password' => 'royfossthornhill',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 2290,
    'cost_distribution' => array(
        'youtube' => 440,
        'new' => 1575,
        'used' => 275,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        // https://app.asana.com/0/687248649257779/1200565843702146
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
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
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#252525',
            '#252525',
),
        'button_color_active' => array(
            '#E1A504',
            '#E1A504',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $500 off your purchase at Royfoss Thornhill',
        'response_email' => 'Hello [name],<p> Thank you for your interest in our newest offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Royfoss Thornhill',
        'forward_to' => array(
            'salesccc@royfoss.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'smedia@royfossthornhill.net',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Roy Foss Thornhill"></id>
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
						<name part="full">Roy Foss Thornhill</name>
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
    "customer_id" => "465-415-5001",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "royfossthornhill",
        'fb_description' => "Are you still interested in the [year] [make] [model] [trim]? Click below for more information or call us at (888) 307-1817.",
        'g_description' => "Are you still interested in the [year] [make] [model] [trim]?",
        'fb_description_new_cadillac' => 'Still interested in the [year] [make] [model] [trim]?  Click for more information or call us at (888) 307-1817.',
        'g_description_new_cadillac' => 'Still interested in the [year] [make] [model] [trim]?',
        //'fb_description_2019_cruze' => "Get as low as 0% financing for 60 months on new 2019 Cruze! Shop below.",
        'fb_lookalike_description' => "Check out this [year] [make] [model] [trim] today. Click for more info!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "custom_banner",
),
        "params" => array(
            "show_stock" => 'yes',
),
        "fb_style" => "facebook_new_ad",
        "font_color" => "#ffffff",
),
);