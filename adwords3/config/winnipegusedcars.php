<?php

global $CronConfigs;
$CronConfigs["winnipegusedcars"] = array(
    //'budget'  => 2.0,
    'password' => 'winnipegusedcars',
    'post_code' => 'E2A 7K2',
    "email" => "regan@smedia.ca",
    'log' => true,
    'tag_debug' => false,
    'bid' => 3.0,
    'cost_distribution' => array(),
    'max_cost' => 0,
    "customer_id" => "960-867-0486",
    'retargetting_delay' => 30000,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "create" => array(
        "new_search" => no,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model].",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model].",
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
    "banner" => array(
        "template" => "winnipegusedcars",
        /* FAST5FLASH SALE */
        "fb_description_2016_328xi" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Not save thousands on your next vehicle purchase?",
        //"fb_description_2018_range rover evoque" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Nott save thousands on your next vehicle purchase?",
        //"fb_description_2018_is300" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Nott save thousands on your next vehicle purchase?",
        //"fb_description_1956_belair" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Nott save thousands on your next vehicle purchase?",
        "fb_description_2016_s60 t5" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Not save thousands on your next vehicle purchase?",
        "fb_description_2018_sienna" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Not save thousands on your next vehicle purchase?",
        "fb_description_2017_e400" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Not save thousands on your next vehicle purchase?",
        "fb_description_2016_cla45" => "Check out Nott Autocorp's Fast Five Flash Sale inventory priced to move. Why Not save thousands on your next vehicle purchase?",
        /*----------------------------*/
        "fb_description" => "Are you still interested in the [year] [make] [model]? Why Not save thousands on your next vehicle purchase?",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Why Not save thousands on your next vehicle purchase?",
        "fb_dynamiclead_description" => "Still interested in this [year] [make] [model]? Click below and fill in your information to get \$200 off coupon. A product specialist will be in touch to help.",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        //"fb_style" => "facebook_new_ad",
        "font_color" => "#000000",
),
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
            '#FAC703',
            '#FAC703',
),
        'button_color_hover' => array(
            '#E1A504',
            '#E1A504',
),
        'button_color_active' => array(
            '#E1A504',
            '#E1A504',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $700 coupon from Nott Autocorp',
        'response_email' => 'Hello [name],<p> Thank you for your interest! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Nott Autocorp',
        'forward_to' => array(
            'emil@smedia.ca',
            'marshal@smedia.ca',
            'tayler@smedia.ca',
),
        'special_to' => array(
            'leads@nottsales.ca',
),
        'special_email' => '<?xml version="1.0"?>
				<?adf version="1.0"?>
					<adf>
						<prospect>
							<id sequence="[total_count]" source="Nott Autocorp"></id>
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
								<name part="full">Nott Autocorp</name>
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
);