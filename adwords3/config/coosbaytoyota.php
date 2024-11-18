<?php

global $CronConfigs;
$CronConfigs["coosbaytoyota"] = array(
    'password' => 'coosbaytoyota',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
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
            '#C5010F',
            '#C5010F',
),
        'button_color_hover' => array(
            '#AC010D',
            '#AC010D',
),
        'button_color_active' => array(
            '#AC010D',
            '#AC010D',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'We will buy your car!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for Coos Bay Toyota’s offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Coos Bay Toyota Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'coosbaytoyota@newsales.leads.cmdlr.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Coos Bay Toyota"></id>
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
							<name part="full">Coos Bay Toyota</name>
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
        'display_after' => 15000,
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
            'vdp' => '/\\/auto\\//i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'banner' => array(
        'template' => 'coosbaytoyota',
        'fb_description' => 'Still interested in the [year] [make] [model]? Powertrain 4 Life Guarantee Only at Coos Bay Toyota! Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Powertrain 4 Life Guarantee Only at Coos Bay Toyota!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'fb_config' => array(
        'monthly_budget' => 200,
        'account_id' => '1404490926255533',
        'page_id' => '142672755752795',
        'pixel_id' => '1931603250453230',
        'dataset' => '101517913796506',
        'form_id' => '',
        'action_types' => array(
            0 => 'click',
),
        'plain' => false,
        'include_stock' => false,
        'polk_data' => true,
        'targeting' => array(
            'desktop' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        0 => array(
                            'key' => 3887,
                            'name' => 'Utah',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        0 => 'home',
),
),
                'publisher_platforms' => array(
                    0 => 'facebook',
),
                'facebook_positions' => array(
                    0 => 'feed',
),
                'device_platforms' => array(
                    0 => 'desktop',
),
),
            'mobile' => array(
                'age_max' => 65,
                'age_min' => 18,
                'geo_locations' => array(
                    'regions' => array(
                        0 => array(
                            'key' => 3880,
                            'name' => 'Oregon',
                            'country' => 'US',
),
),
                    'location_types' => array(
                        0 => 'home',
),
),
                'publisher_platforms' => array(
                    0 => 'facebook',
),
                'facebook_positions' => array(
                    0 => 'feed',
),
                'device_platforms' => array(
                    0 => 'mobile',
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17571',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'name' => 'coosbaytoyota',
);