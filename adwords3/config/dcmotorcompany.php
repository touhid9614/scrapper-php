<?php

global $CronConfigs;
$CronConfigs["dcmotorcompany"] = array(
    'name' => 'dcmotorcompany',
    'email' => 'regan@smedia.ca',
    'password' => 'dcmotorcompany',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'dcmotorcompany',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => true,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#1C1C1C',
            '#1C1C1C',
),
        'button_color_hover' => array(
            '#878787',
            '#878787',
),
        'button_color_active' => array(
            '#878787',
            '#878787',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => '$200 off coupon from D&C Motors',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>D and C Motors Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'webleads@dcmotors.dsmessage.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="D and C Motors"></id>
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
						<vendorname>D And C Motors</vendorname>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia</name>
					<url>https://smedia.ca</url>
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
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
);