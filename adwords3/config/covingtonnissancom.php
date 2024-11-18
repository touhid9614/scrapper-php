<?php

global $CronConfigs;
$CronConfigs["covingtonnissancom"] = array(
    "name" => " covingtonnissancom",
    "email" => "regan@smedia.ca",
    "password" => " covingtonnissancom",
    "log" => true,
    'smart_banner' => array(
        'live' => null,
        'title' => 'Get peace of mind',
),
    'lead' => array(
        'live' => true,
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
            '#C31F31',
            '#C31F31',
),
        'button_color_hover' => array(
            '#FF2940',
            '#C72032',
),
        'button_color_active' => array(
            '#470B12',
            '#610F18',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Lifetime Limited Powertrain Warranty from Covington Nissan',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Covington Nissan Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@covington.dsmessage.com',
),
        'special_email'         =>  '<?xml version="1.0"?>
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
					<vendorname>Covington Nissan</vendorname>
					<contact>
						<name part="full">Covington Nissan</name>
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
            'vdp' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'service' => '',
),
),
);