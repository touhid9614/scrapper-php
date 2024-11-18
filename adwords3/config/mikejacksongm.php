<?php

global $CronConfigs;
$CronConfigs["mikejacksongm"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'password' => 'mikejacksongm',
    'max_cost' => 870,
    'cost_distribution' => array(
        'youtube' => 130,
        'used' => 405,
        'new' => 405,
),
    "email" => "regan@smedia.ca",
    'post_code' => 'l9y1w6',
    'bing_account_id' => 156002880,
    //tracker
    'company_name' => 'Mike Jackson Chevrolet Cadillac Buick GMC',
    "create" => array(
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
        "used_placement" => yes,
        "new_placement" => yes,
),
    "bing_create" => array(
        "new_search" => true,
),
    "host_url" => "http://www.mikejacksongm.com",
    //must start with http or https and end without /
    "display_url" => "www.mikejacksongm.com",
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
    "certified_descs" => array(
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
    "customer_id" => "924-904-8253",
    "email" => "regan@smedia.ca",
    "banner" => array(
        "template" => "mikejacksongm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
		//"fb_description_2019_spark" => "Get FREE Winter Tires on Rims when you buy a new 2019 Spark! Shop now!",
        "fb_style" => 'fb_new_rightsidebar',
        "flash_style" => "default",
        "hst" => yes,
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
            '#1E71B8',
            '#1E71B8',
),
        'button_color_hover' => array(
            '#10385B',
            '#10385B',
),
        'button_color_active' => array(
            '#10385B',
            '#10385B',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 coupon from Mike Jackson GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Mike Jackson GM Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'sales@mikejacksongm.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Mike Jackson GM"></id>
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
						<name part="full">Mike Jackson GM</name>
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