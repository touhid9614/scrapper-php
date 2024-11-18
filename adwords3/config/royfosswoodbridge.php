<?php

global $CronConfigs;
$CronConfigs["royfosswoodbridge"] = array(
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'password' => 'royfosswoodbridge',
    'max_cost' => 500,
    'cost_distribution' => array(
        'adwords' => 500,
),
    'company_name' => 'Woodbridge',
    'log' => true,
    'email' => 'regan@smedia.ca',
    'post_code' => 'L4L 8R1',
    'trackers' => array(
        'new_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
),
    'create' => array(),
    'host_url' => 'http://www.royfosswoodbridge.com',
    'display_url' => 'www.royfosswoodbridge.com',
    'new_descs' => array(
        0 => array(
            'desc1' => 'Come see the [year]',
            'desc2' => '[make] [model] today.  Stock number- [stock_number]',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[make] [model] today.  Stock number- [stock_number]',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Come see the [year]',
            'desc2' => '[make] [model] today.  Stock number- [stock_number]',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[make] [model] today.  Stock number- [stock_number]',
),
),
    'options_descs' => array(
        0 => array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
        0 => array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'customer_id' => '374-204-6959',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'royfosswoodbridge',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.', 
        'fb_description_new' => 'Still interested in the [year] [make] [model]? Click for more information. Stock #- [stock_number]. Price [price]. ',
        'fb_description_used' => 'Still interested in the [year] [make] [model]? Click for more information. Stock #- [stock_number]. Price [price]',
        'fb_lookalike_description_new' => 'Check out this [year] [make] [model] today. Click for more information. Stock #- [stock_number]. Price [price].',
        'fb_lookalike_description_used' => 'Check out this [year] [make] [model] today. Click for more information. Stock #- [stock_number]. Price [price]',
        'fb_dynamiclead_description' => 'Still interested in the [year] [make] [model]? Click below, fill in your information and our product specialist will be in touch to help.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'hst' => true,
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'params' => array(
            'show_stock' => 'yes',
),
        'font_color' => '#f7f7f7',
),
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#efefef',
        'text_color' => '#404450',
        'border_color' => '#e5e5e5',
        'button_color' => array(
            0 => '#2aabb2',
            1 => '#2aabb2',
),
        'button_color_hover' => array(
            0 => '#25979d',
            1 => '#25979d',
),
        'button_color_active' => array(
            0 => '#25979d',
            1 => '#25979d',
),
        'button_text_color' => '#ffffff',
        'response_email_subject' => 'Boxing Week Pricing at Roy Foss Woodbridge',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Roy Foss Woodbridge Team',
        'forward_to' => array(
            0 => 'salesccc@royfoss.com',
            1 => 'salaimo@royfoss.com',
            2 => 'jsales@royfoss.com',
            3 => 'marshal@smedia.ca',
),
        'special_to' => array(
            0 => '1137ryfmsalesleads11@dealermineinc.com',
            1 => '1137ryfmserviceleads11@dealermineinc.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Roy Foss Woodbridge"></id>
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
							<name part="full">Roy Foss Woodbridge</name>
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
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/(?:new|used|certified-used|certified)-[0-9]{4}-/',
            'service_regex' => '',
),
),
    'name' => 'royfosswoodbridge',
);