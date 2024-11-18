<?php

global $CronConfigs;
$CronConfigs["rockys_harley"] = array(
    "name" => " rockys_harley",
    "email" => "regan@smedia.ca",
    "password" => " rockys_harley",
    "log" => true,
    "bing_account_id" => 156002953,
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
        "template" => "rockys_harley",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Stop dreaming and start riding a Harley-Davidson® motorcycle! Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]. Stop dreaming and start riding a Harley-Davidson® motorcycle! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
            '#903E28',
            '#903E28',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#000000',
            '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'At Rocky\'s Harley-Davidson, We\'ll Bring The Experience To You!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Rocky\'s Harley Team',
        'forward_to' => array(
            'Dfisher@rockys-harley.com',
            'pamma@rockys-harley.com',
            'Jeff@rockys-harley.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@dp360crm.com',
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
					<vendorname>Rocky\'s Harley-Davidson</vendorname>					
					<contact>
						<name part="full">Rocky\'s Harley-Davidson</name>
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
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-5-modal"]',
            'css-class' => '[data-target="vdp_button_widget-5-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-5-modal"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '[data-target="vdp_button_widget-5-modal"]',
                    'values' => array(
                        'Apply for Financing',
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Special FInance Offers',
                        'Financing Options',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9A1620,#9A1620)',
                        'border-color' => '9A1620',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#414141,#414141)',
                        'border-color' => '414141',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-4-modal"]',
            'css-class' => '[data-target="vdp_button_widget-4-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-4-modal"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '[data-target="vdp_button_widget-4-modal"]',
                    'values' => array(
                        'Schedule a Test',
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Want to Test Drive?',
                        'Schedule My Visit',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9A1620,#9A1620)',
                        'border-color' => '9A1620',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#414141,#414141)',
                        'border-color' => '414141',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-3-modal"]',
            'css-class' => '[data-target="vdp_button_widget-3-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-3-modal"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[data-target="vdp_button_widget-3-modal"]',
                    'values' => array(
                        'Contact Us',
                        'Call Us Today',
                        'Reach Us',
                        'Click Here To Contact Us',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9A1620,#9A1620)',
                        'border-color' => '9A1620',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#414141,#414141)',
                        'border-color' => '414141',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-6-modal"]',
            'css-class' => '[data-target="vdp_button_widget-6-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-6-modal"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '[data-target="vdp_button_widget-6-modal"]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Evaluate Your Trade In',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9A1620,#9A1620)',
                        'border-color' => '9A1620',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#414141,#414141)',
                        'border-color' => '414141',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
),
],
],
);