<?php

global $CronConfigs;
$CronConfigs["hammerchevy"] = array(
    'password' => 'hammerchevy',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "hammerchevy",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
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
            '#385C77',
            '#385C77',
        ),
        'button_color_hover' => array(
            '#304F66',
            '#304F66',
        ),
        'button_color_active' => array(
            '#304F66',
            '#304F66',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF offer from Hammer Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Hammer Chevrolet Team',
        'forward_to' => array(
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'leads@hammerchevrolet.motosnap.com',
        ),
        'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Hammer Chevrolet"></id>
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
					<name part="full">Hammer Chevrolet</name>
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17583',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);