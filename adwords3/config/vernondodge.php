<?php

global $CronConfigs;
$CronConfigs["vernondodge"] = array(
    'password' => 'vernondodge',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'tag_debug' => false,
    //   'retargetting_delay' => 30000,
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#891C1D',
            '#891C1D',
        ),
        'button_color_hover' => array(
            '#711314',
            '#711314',
        ),
        'button_color_active' => array(
            '#891C1D',
            '#891C1D',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Vernon Dodge',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Vernon Dodge Team',
        'forward_to' => array(
            'dan@vernondodge.com',
            'marshal@smedia.ca',
            'tiffany@smedia.ca',
            'smedia@vernondodgejeep.net',
        ),
        'special_to' => array(
            'smedia@vernondodgejeep.net',
            'thamina.ahamed@gmail.com',
        ),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Vernon Dodge"></id>
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
							<name part="full">Vernon Dodge</name>
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
    "log" => true,
    'max_cost' => 0,
    "create" => array(
        "new_search" => no,
        "used_search" => no,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => no,
    ),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.Let Us Bring The Test Drive To You!",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model].Let Us Bring The Test Drive To You!",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.Let Us Bring The Test Drive To You!",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model].Let Us Bring The Test Drive To You!",
        ),
    ),
    //"customer_id" => "934-243-0260",
    "banner" => array(
        "template" => "vernondodge",
        "fb_description_new" => "Still interested in this [year] [make] [model]? Visit the friendliest dealer in the Okanagan today! See you at the Fun Store!",
		"fb_description_used" => "Still interested in this [year] [make] [model]? All pre-owned vehicles come with 60 DAYS peace of mind warranty. Join the family today!",
        "fb_lookalike_description_new" => "Come see this [year] [make] [model]. Visit the friendliest dealer in the Okanagan today! See you at the Fun Store!",
		"fb_lookalike_description_used" => "Come see this [year] [make] [model]. All pre-owned vehicles come with 60 DAYS peace of mind warranty. Join the family today!",
        "fb_dynamiclead_description" => "Interested in purchasing a vehicle from us? Why not claim \$200 OFF? Click below and fill in your information to get the offer.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
        ),
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_style" => "facebook_new_ad",
        "font_color" => "#ffffff",
//        'fb_title' => '[year] [make] [model] [price]',
    ),
);