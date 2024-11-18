<?php

global $CronConfigs;
$CronConfigs["stephenwadetoyota"] = array(
    "name" => "stephenwadetoyota",
    "email" => "regan@smedia.ca",
    "password" => "stephenwadetoyota",
    "log" => true,
    "banner" => array(
        "template" => "stephenwadetoyota",
        "fb_description" => "Are you still interested in a [year] [make] [model]? Click for more information!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => false,
        'lead_type_used' => true,
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
            '#ED1C24',
            '#ED1C24',
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
        'response_email_subject' => '$200 off coupon from Stephen Wade Toyota',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Stephen Wade Toyota Team',
        'forward_to' => array(
            'toyotasales@stephenwade.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'toyotacrmleads@stephenwade.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Stephen Wade Toyota"></id>
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
						<name part="full">Stephen Wade Toyota</name>
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
),
    'adf_to' => array(
        'toyotacrmleads@stephenwade.com',
),
    'lead_to' => array(
        'toyotasales@stephenwade.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        //new//
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/(?:used|new)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.expanded.secondary[href*=credit-application]',
            'css-class' => 'a.button.expanded.secondary[href*=credit-application]',
            'css-hover' => 'a.button.expanded.secondary[href*=credit-application]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a.button.expanded.secondary[href*=credit-application]',
                    'values' => array(
                        'Get Approved Online',
                        'Apply for Financing',
                        'No hassle financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Explore Payments',
                        'Financing Options',
                        'Calculate Lease Payment',
                        'Estimate Payments',
                        'Get Pre-Approved',
),
],
],
            'styles' => array(
                'dark_blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#425368,#425368)',
                        'border-color' => '425368',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED1C24,#ED1C24)',
                        'border-color' => 'ED1C24',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
                'dark_grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
),
],
        //new//
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/(?:used|new)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=schedule-test-drive]',
            'css-class' => 'a[href *=schedule-test-drive]',
            'css-hover' => 'a[href *=schedule-test-drive]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href *=schedule-test-drive]',
                    'values' => array(
                        'Request a Test Drive',
                        'Test Drive This Vehicle',
                        'Test Drive Booking',
                        'Trade Offer',
                        'Want to Test Drive?',
                        'Book Test Drive',
                        'Priority Test Drive',
                        'VIP Test Drive',
                        'Schedule My Visit',
                        'Check Availability',
),
],
],
            'styles' => array(
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED1C24,#ED1C24)',
                        'border-color' => 'ED1C24',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
                'dark_blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#425368,#425368)',
                        'border-color' => '425368',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
                'dark_grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
],
);