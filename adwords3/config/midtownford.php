<?php

global $CronConfigs;
$CronConfigs["midtownford"] = array(
    'password' => 'midtownford',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    "email" => "regan@smedia.ca",
    'max_cost' => 7500.0,
    "email" => "regan@smedia.ca",
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
            '#0066CC',
            '#0066CC',
),
        'button_color_hover' => array(
            '#0066CC',
            '#007AF3',
),
        'button_color_active' => array(
            '#0066CC',
            '#0066CC',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $500 off coupon from MidTown Ford ',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Mid-Town Ford Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@midtownford.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="MidTown Ford"></id>
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
							<name part="full">MidTown Ford</name>
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
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service' => '',
),
),
    'new_title2' => 'See Inventory, Prices & Offers',
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
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "customer_id" => "327-834-6314",
    "banner" => array(
        "template" => "midtownford",
        //'fb_style' => "mainlinechrysler",
        'fb_description_new' => 'Are you still interested in the [year] [make] [model]? Click here or give us a call at 204-515-6578 for more information.',
        'fb_description_used' => 'Click here to get your E-Price on the [year] [make] [model] or give us a call at 204-515-6578 today!',
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_f150special_description" => "Shop below for our new Ford F150 specials!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "old_price" => "msrp",
        //"old_price"  => true,
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#ffffff",
),
);