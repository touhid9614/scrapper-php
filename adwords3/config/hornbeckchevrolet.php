<?php

global $CronConfigs;
$CronConfigs["hornbeckchevrolet"] = array(
    "name" => " hornbeckchevrolet",
    "email" => "regan@smedia.ca",
    "password" => " hornbeckchevrolet",
    "log" => true,
    "banner" => array(
        "template" => "hornbeckchevrolet",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    "lead" => array(
        'new' => array(
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
                '#CFAB39',
                '#BB9A33',
),
            'button_color_hover' => array(
                '#BB9A33',
                '#CFAB39',
),
            'button_color_active' => array(
                '#BB9A33',
                '#BB9A33',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => '$200 off voucher from Hornbeck Chevrolet',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Hornbeck Chevrolet Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'Leads@hornbeckchevy.com',
),
            'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="sMedia Coupon - $200 OFF"></id>
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
						<vendorname>Hornbeck Chevrolet</vendorname>
						<contact>
							<name part="full">Hornbeck Chevrolet</name>
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
                'vdp' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
                'service' => '',
),
),
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
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
                '#CFAB39',
                '#BB9A33',
),
            'button_color_hover' => array(
                '#BB9A33',
                '#CFAB39',
),
            'button_color_active' => array(
                '#BB9A33',
                '#BB9A33',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Hornbeck Chevrolet Will Buy Your Car!',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Hornbeck Chevrolet Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'Leads@hornbeckchevy.com',
),
            'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia smart offer - Buy Car"></id>
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
					<vendorname>Hornbeck Chevrolet</vendorname>
					<contact>
						<name part="full">Hornbeck Chevrolet</name>
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
                'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
                'service' => '',
),
),
),
);