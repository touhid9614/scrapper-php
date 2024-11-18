<?php

global $CronConfigs;
$CronConfigs["appelford"] = array(
    'password' => 'appelford',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "appelford",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'fb_2019clearout_description' => "Are you still interested in the [year] [make] [model]? Get your best deal with our 2019 Models Clearout! Shop now!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => false,
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
            '#00BEFA',
            '#00BEFA',
),
        'button_color_hover' => array(
            '#0D65B0',
            '#0D65B0',
),
        'button_color_active' => array(
            '#0D65B0',
            '#0D65B0',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$300 OFF coupon from Appel Ford',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Appel Ford Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'appelford@forddirectcrm.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Appel Ford"></id>
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
							<name part="full">Appel Ford</name>
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
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17564',
        'promotion_text' => 'CLAIM $250 OFF!',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#009AD6',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#009AD6',
        'coupon_validity' => '30',
),
);