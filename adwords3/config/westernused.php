<?php

global $CronConfigs;
$CronConfigs["westernused"] = array(
    "name" => " westernused",
    "email" => "regan@smedia.ca",
    "password" => " westernused",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "banner" => array(
        "template" => "westernused",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        'fb_style' => 'westernused_fb',
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
            '#FF5800',
            '#FF5800',
        ),
        'button_color_hover' => array(
            '#853409',
            '#853409',
        ),
        'button_color_active' => array(
            '#853409',
            '#853409',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim $1,000 Cashback from Western Used',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Western Used Team',
        'forward_to' => array(
            'usedwebleads@westernused.com',
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'tivany@westernused.com',
        ),
        'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="westernused"></id>
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
					<name part="full">westernused</name>
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