<?php

global $CronConfigs;
$CronConfigs["nanaimohonda"] = array(
    "name" => " nanaimohonda",
    "email" => "regan@smedia.ca",
    "password" => " nanaimohonda",
    "log" => true,
    'bing_account_id' => 156002866,
    "customer_id" => "489-752-6241",
    'max_cost' => 405,
    'cost_distribution' => array(
        'adwords' => 405,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "banner" => array(
        "template" => "nanaimohonda",
        //"fb_description" => "Are you still interested in [year] [make] [model]? Come shop Nanaimo Honda\'s inventory and get into the vehicle that's right for you!",
        //"fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_description" => "Are you still interested in [year] [make] [model]? We are here to help, shop safely from home. Call, text or email.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! We are here to help, shop safely from home. Call, text or email.",
        //"fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
		"fb_dynamiclead_description" => "We're here to help you get BACK ON THE ROAD! Bring your 2016 or older Honda for any scheduled maintenance and get: 1 Year Complimentary Roadside Assistance Package and A Free Multi-point Inspection*. Get this offer now!",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
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
            '#D71221',
            '#D71221',
),
        'button_color_hover' => array(
            '#A80F1A',
            '#A80F1A',
),
        'button_color_active' => array(
            '#A80F1A',
            '#A80F1A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Nanaimo Honda',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Nanaimo Honda Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'smedia@nanaimohonda.net',
            'leads@nanaimohondasales.com ',
            'nanang@smedia.ca',
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
					<contact>
						<name part="full">Nanaimo Honda</name>
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
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service' => '',
),
),
    'adf_to' => 'smedia@nanaimohonda.net',
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.eprice-link a',
            'css-class' => 'div.eprice-link a',
            'css-hover' => 'div.eprice-link a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.eprice-link a',
                    'values' => array(
                        'Get Special Pricing',
                        'Get More Details',
                        'Ask for More Info',
                        'Request More Info',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D71321,#D71321)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#AC1520,#AC1520)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#114169,#114169)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0E3251,#0E3251)',
                        'border-color' => 'C60C0D',
),
),
),
],
],
);