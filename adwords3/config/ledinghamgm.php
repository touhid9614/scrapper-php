<?php

global $CronConfigs;
$CronConfigs["ledinghamgm"] = array(
    "name" => " ledinghamgm",
    "email" => "regan@smedia.ca",
    "password" => " ledinghamgm",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bing_account_id' => 156002829,
    "log" => true,
    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "ledinghamgm",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
        "font_color" => "#ffffff",
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
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#943131",
            "#943131",
),
        'button_color_hover' => array(
            "#ff0000",
            "#ff0000",
),
        'button_color_active' => array(
            "#ff0000",
            "#ff0000",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Ledingham GM",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Ledingham GM Team",
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'smedia@ledinghamchev.net',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Ledingham GM"></id>
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
						<name part="full">Ledingham GM</name>
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
    'lead_to' => 'sales@ledinghamgm.com',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06338D,#06338D)',
                        'border-color' => '06338D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#04276D,#04276D)',
                        'border-color' => '04276D',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A52929,#A52929)',
                        'border-color' => 'A52929',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#872121,#872121)',
                        'border-color' => '872121',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E5AE22,#E5AE22)',
                        'border-color' => 'E5AE22',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CB9B20,#CB9B20)',
                        'border-color' => 'CB9B20',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#515151,#515151)',
                        'border-color' => '515151',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3A3A3A,#3A3A3A)',
                        'border-color' => '3A3A3A',
                        'color' => '#fff',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06338D,#06338D)',
                        'border-color' => '06338D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#04276D,#04276D)',
                        'border-color' => '04276D',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A52929,#A52929)',
                        'border-color' => 'A52929',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#872121,#872121)',
                        'border-color' => '872121',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E5AE22,#E5AE22)',
                        'border-color' => 'E5AE22',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CB9B20,#CB9B20)',
                        'border-color' => 'CB9B20',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#515151,#515151)',
                        'border-color' => '515151',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3A3A3A,#3A3A3A)',
                        'border-color' => '3A3A3A',
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
            'action-target' => 'div.link a[name="1e33229c-a548-4ef0-8d4f-71c74ef726f7"]',
            'css-class' => 'div.link a[name="1e33229c-a548-4ef0-8d4f-71c74ef726f7"]',
            'css-hover' => 'div.link a[name="1e33229c-a548-4ef0-8d4f-71c74ef726f7"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.link a[name="1e33229c-a548-4ef0-8d4f-71c74ef726f7"]',
                    'values' => array(
                        'Get Pre-Approved',
                        'Apply for Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#06338D,#06338D)',
                        'border-color' => '06338D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#04276D,#04276D)',
                        'border-color' => '04276D',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A52929,#A52929)',
                        'border-color' => 'A52929',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#872121,#872121)',
                        'border-color' => '872121',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E5AE22,#E5AE22)',
                        'border-color' => 'E5AE22',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CB9B20,#CB9B20)',
                        'border-color' => 'CB9B20',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#515151,#515151)',
                        'border-color' => '515151',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3A3A3A,#3A3A3A)',
                        'border-color' => '3A3A3A',
                        'color' => '#fff',
),
),
),
],
],
    "customer_id" => "213-610-3468",
    'max_cost' => 3100,
    'cost_distribution' => array(
        'adwords' => 3100,
),
);