<?php

global $CronConfigs;
$CronConfigs["lexusofarlington"] = array(
    'password' => 'lexusofarlington',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "customer_id"   => "339-549-5542",
    'banner' => array(
        'template' => 'lexusofarlington',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => false,
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
            0 => array(
                'new' => 679,
                'used' => 679,
),
            1 => '#000000',
),
        'button_color_hover' => array(
            0 => '#333333',
            1 => '#333333',
),
        'button_color_active' => array(
            0 => '#333333',
            1 => '#333333',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '5 Year Complimentary Scheduled Maintenance Included.',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Lexus of Arlington Team',
        'forward_to' => array(
            0 => 'marshal@smedia.ca',
),
        'special_to' => array(
            0 => 'leads@lexusofarlington.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Lexus of Arlington"></id>
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
						<name part="full">Lexus of Arlington</name>
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
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => NULL,
),
),
    'name' => 'lexusofarlington',
    'max_cost' => 1350,
    'cost_distribution' => array(
        'new' => 675,
        'used' => 675,
),
);