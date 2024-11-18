<?php

global $CronConfigs;
$CronConfigs["pentictontoyota"] = array(
    'password' => 'pentictontoyota',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "pentictontoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_lookalike_description_2019_sequoia" => "Get savings of \$6500 on remaining 2019 Toyota Sequoia!",
        "fb_lookalike_description_2019_86" => "Get savings of \$2000 on remaining 2019 Toyota 86 GT!",
        //"fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
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
            '#EB0A1E',
            '#EB0A1E',
),
        'button_color_hover' => array(
            '#C01E2C',
            '#C01E2C',
),
        'button_color_active' => array(
            '#C01E2C',
            '#C01E2C',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 OFF coupon from Penticton Toyota',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your 	phone to claim.</p><br><img src="[image]"/><p><br><br>Penticton Toyota Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'sales@pentictontoyota.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
				<adf>
					<prospect>
						<id sequence="[total_count]" source="Penticton Toyota"></id>
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
							<name part="full">Penticton Toyota</name>
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