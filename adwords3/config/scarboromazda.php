<?php

global $CronConfigs;
$CronConfigs["scarboromazda"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'password' => 'scarboromazda',
    'post_code' => 'L2R5L3',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "customer_id" => "827-353-9876",
    "banner" => array(
        "template" => "scarboromazda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Shop from the comfort of your home",
        "fb_lookalike_description" => "Shop this [year] [make] [model] from the comfort of your home. Click for more information.",
        "flash_style" => "default",
        "hst" => yes,
        "border_color" => "#282828",
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
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'fb_retarget_after' => 10,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0089D0',
            '#0089D0',
),
        'button_color_hover' => array(
            '#00A5FF',
            '#00A5FF',
),
        'button_color_active' => array(
            '#00A5FF',
            '#00A5FF',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF offer from Scarboro Mazda',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Scarboro Mazda Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@scarboromazdaleads.ca',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Scarboro Mazda"></id>
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
					<name part="full">Scarboro Mazda</name>
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
    'max_cost' => 1000,
    'cost_distribution' => array(
        'new' => 500,
        'used' => 500,
),
);