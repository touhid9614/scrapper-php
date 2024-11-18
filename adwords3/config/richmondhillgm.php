<?php

global $CronConfigs;
$CronConfigs["richmondhillgm"] = array(
    "name" => "richmondhillgm",
    "email" => "regan@smedia.ca",
    "password" => "richmondhillgm",
    "log" => true,
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#1e4387",
            "#1e4387",
),
        'button_color_hover' => array(
            "#1a3972",
            "#1a3972",
),
        'button_color_active' => array(
            "#1a3972",
            "#1a3972",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "Receive a \$10 Esso Gas Card with a Test Drive!",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Wilson Niblett Team",
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'leads@wilsonniblett.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Wilson Nibblett"></id>
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
						<name part="full">Wilson Nibblett</name>
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
    'adf_to' => array(
        'leads@wilsonniblett.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Get Local Pricing',
                        'Get Best Price',
                        'Get E-Price',
                        'Get Internet Price',
                        'Get Special Price',
                        'Get Your Exclusive Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E31836,#E31836)',
                        'border-color' => 'E31836',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A31228,#A31228)',
                        'border-color' => 'A31228',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C7294,#4C7294)',
                        'border-color' => '4C7294',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2B4154,#2B4154)',
                        'border-color' => '2B4154',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F9B718,#F9B718)',
                        'border-color' => 'F9B718',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA8813,#BA8813)',
                        'border-color' => 'BA8813',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#474747,#474747)',
                        'border-color' => '474747',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E31836,#E31836)',
                        'border-color' => 'E31836',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A31228,#A31228)',
                        'border-color' => 'A31228',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C7294,#4C7294)',
                        'border-color' => '4C7294',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2B4154,#2B4154)',
                        'border-color' => '2B4154',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F9B718,#F9B718)',
                        'border-color' => 'F9B718',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA8813,#BA8813)',
                        'border-color' => 'BA8813',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#474747,#474747)',
                        'border-color' => '474747',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="8a839b7d-c303-493d-b08a-1861f3b8eb59"]',
            'css-class' => '[name="8a839b7d-c303-493d-b08a-1861f3b8eb59"]',
            'css-hover' => '[name="8a839b7d-c303-493d-b08a-1861f3b8eb59"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '[name="8a839b7d-c303-493d-b08a-1861f3b8eb59"]',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'Trade Offer',
                        'Trade-In Appraisal',
                        'Get Trade-In Value',
                        'Appraise Your Trade',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E31836,#E31836)',
                        'border-color' => 'E31836',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A31228,#A31228)',
                        'border-color' => 'A31228',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C7294,#4C7294)',
                        'border-color' => '4C7294',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2B4154,#2B4154)',
                        'border-color' => '2B4154',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F9B718,#F9B718)',
                        'border-color' => 'F9B718',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA8813,#BA8813)',
                        'border-color' => 'BA8813',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#474747,#474747)',
                        'border-color' => '474747',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
],
    'email_templates' => [
        'e-price' => [
            'subject' => "CDK Leads",
],
        'test-drive' => [
            'subject' => "CDK Leads",
],
],
);