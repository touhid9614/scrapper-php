<?php

global $CronConfigs;
$CronConfigs["cheyennegm"] = array(
    "name" => " cheyennegm",
    "email" => "regan@smedia.ca",
    "password" => " cheyennegm",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "banner" => array(
        "template" => "cheyennegm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#EF2129',
            '#C60021',
),
        'button_color_hover' => array(
            '#C60021',
            '#EF2129',
),
        'button_color_active' => array(
            '#C60021',
            '#EF2129',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Cheyenne Motor Products',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Cheyenne Motor Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'accountingcheyennegm@sasktel.net',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Cheyenne Motor Products"></id>
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
							<name part="full">Cheyenne Motor Products</name>
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
),
    'lead_to' => '',
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
                    'values' => array(
                        'Get a Quote',
                        'Get e-Price',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Best Price',
                        'Get Market Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request a Quote',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E00000,#E00000)',
                        'border-color' => 'E00000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00C600,#00C600)',
                        'border-color' => '00C600',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0070E0,#0070E0)',
                        'border-color' => '0070E0',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F97D00,#F97D00)',
                        'border-color' => 'F97D00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule Your Test Drive',
                        'Test Drive',
                        'Test Drive Today',
                        'Book a Test Drive',
                        'Want to Test Drive It?',
                        'Schedule Your Visit',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E00000,#E00000)',
                        'border-color' => 'E00000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00C600,#00C600)',
                        'border-color' => '00C600',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0070E0,#0070E0)',
                        'border-color' => '0070E0',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F97D00,#F97D00)',
                        'border-color' => 'F97D00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#676767,#676767)',
                        'border-color' => '676767',
),
),
),
],
],
);