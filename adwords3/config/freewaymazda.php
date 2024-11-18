<?php

global $CronConfigs;
$CronConfigs["freewaymazda"] = array(
    'name' => 'freewaymazda',
    'password' => 'freewaymazda',
    'max_cost' => 1550,
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'combined_feed_mode' => true,
    'log' => true,
    'create' => array(),
    'new_descs' => array(
         array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
         array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
         array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
         array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'options_descs' => array(
         array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
         array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'customer_id' => '576-499-2788',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'freewaymazda',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for further information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to get $200 OFF and a product specialist will be in touch to answer any questions.',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
             '#1A93D7',
             '#1A93D7',
),
        'button_color_hover' => array(
             '#000000',
             '#000000',
),
        'button_color_active' => array(
             '#333333',
             '#333333',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 OFF coupon from Freeway Mazda',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Freeway Mazda Team',
        'forward_to' => array(
             'marshal@smedia.ca',
),
        'special_to' => array(
             'smedia@freewaymazda.net',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Freeway Mazda"></id>
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
							<name part="full">Freeway Mazda</name>
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
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
            'service_regex' => '',
),
),
    'form_live' => false,
    'buttons_live' => false,
    'mail_retargeting' => array(
        'enabled' => NULL,
        'client_id' => '',
        'promotion_text' => 'Show this at purchase!',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'cost_distribution' => array(
        'new' => 775,
        'used' => 775,
),
    'smart_memo' => array(
        'live' => false,
        'live_new' => false,
        'live_used' => false,
        'live_home' => false,
        'live_service' => false,
        'video' => false,
        'video_url' => '',
        'button_text' => 'learn more',
        'url' => '',
        'home_url' => '',
        'service_regex' => '',
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
),
);