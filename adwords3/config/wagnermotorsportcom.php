<?php

global $CronConfigs;
$CronConfigs["wagnermotorsportcom"] = array(
    "name" => " wagnermotorsportcom",
    "email" => "regan@smedia.ca",
    "password" => " wagnermotorsportcom",
    "log" => true,
    "banner" => array(
        "template" => "wagnermotorsportcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
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
            '#08548E',
            '#08548E',
),
        'button_color_hover' => array(
            '#05375E',
            '#05375E',
),
        'button_color_active' => array(
            '#05375E',
            '#05375E',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$100 off coupon from Wagner Motorsports',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Wagner Motorsports Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'v2_leads@dp360crm.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
					<vendorname>Wagner Motorsports</vendorname>
					<contact>
						<name part="full">Wagner Motorsports</name>
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
            'vdp' => '/\\/(?:new-models|inventory)\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17904',
        'promotion_text' => '$100 OFF',
        'promotion_color' => '#04558D',
        'overlay_color' => '#04558D',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#04558D',
        'coupon_validity' => '7',
),
);