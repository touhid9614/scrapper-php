<?php

global $CronConfigs;
$CronConfigs["westtexasnissan"] = array(
    "name" => " westtexasnissan",
    "email" => "regan@smedia.ca",
    "password" => " westtexasnissan",
    "log" => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#cc0033",
            "#cc0033",
),
        'button_color_hover' => array(
            "#b3002d",
            "#b3002d",
),
        'button_color_active' => array(
            "#b3002d",
            "#b3002d",
),
        'button_text_color' => "#ffffff",
        'forward_email_subject' => "SMART OFFER SMEDIA",
        'response_email_subject' => "\$250 off coupon from West Texas Nissan",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>West Texas Nissan Team",
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'leads@westtexasnissan.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="West Texas Nissan"></id>
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
						<name part="full">West Texas Nissan</name>
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
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]',
            'css-class' => '[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]',
            'css-hover' => '[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="d8beb5fb-e566-40f8-94a4-898d3d5d1b58"]',
                    'values' => array(
                        'Get Your Price',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Get A Quote',
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
),
],
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="feba3091-4e1b-4e29-b47e-cb4ccf123619"]',
            'css-class' => '[name="feba3091-4e1b-4e29-b47e-cb4ccf123619"]',
            'css-hover' => '[name="feba3091-4e1b-4e29-b47e-cb4ccf123619"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'price-watch' => [
                    'target' => '[name="feba3091-4e1b-4e29-b47e-cb4ccf123619"]',
                    'values' => array(
                        'Get Price Alerts',
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
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
),
],
        'financing' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]',
            'css-class' => '[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]',
            'css-hover' => '[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '[name="3ad202f5-1c6d-42cf-b657-540f87079e5e"]',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'Special Finance Offers',
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
),
],
],
);