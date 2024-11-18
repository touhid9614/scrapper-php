<?php

global $CronConfigs;
$CronConfigs["beckmastennorth"] = array(
    "name" => " beckmastennorth",
    "email" => "regan@smedia.ca",
    "password" => " beckmastennorth",
    "log" => true,
    'combined_feed_mode' => true,
    'max_cost' => .01,
    'cost_distribution' => array(
        'adwords' => .01,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
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
    'customer_id' => '781-625-8700',

    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "beckmastennorth",
        "snapchat_style" => "snapchat_custom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information or visit us at 11300 Farm to Market 1960 Rd W, Houston, TX 77065, United States.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]. Click for more information or visit us at 11300 Farm to Market 1960 Rd W, Houston, TX 77065, United States.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner"
        ),
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#A90000',
            '#A90000',
),
        'button_color_hover' => array(
            '#440101',
            '#440101',
),
        'button_color_active' => array(
            '#440101',
            '#440101',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 off coupon from Beck & Masten North',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Beck & Masten North Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'sales@beckandmastennorth.edealerhub.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Beck & Masten North"></id>
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
						<name part="full">Beck & Masten North</name>
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
    'adf_to' => array(
        'sales@beckandmastennorth.edealerhub.com',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        //get price updates//
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name*="a9e0c5d9-cc6c-406f-9880-51097a4c06d1"]',
            'css-class' => 'a[name*="a9e0c5d9-cc6c-406f-9880-51097a4c06d1"]',
            'css-hover' => 'a[name*="a9e0c5d9-cc6c-406f-9880-51097a4c06d1"]:hover',
            'button_action' => [
                'form',
                'e-price-new',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name*="a9e0c5d9-cc6c-406f-9880-51097a4c06d1"]',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'GET CURRENT MARKET PRICE',
                        'GET DETAILS',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Confirm Availability',
                        'Get Your Exclusive Price',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0097CE,#0097CE)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0084B4,#0084B4)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED775B,#ED775B)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D36A51,#D36A51)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B20000,#B20000)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6E6F74,#6E6F74)',
                        'border-color' => '6E6F74',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#56575A,#56575A)',
                        'border-color' => '56575A',
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
            'action-target' => 'a[name="22772614-9929-4697-af17-d332a8cef12d"]',
            'css-class' => 'a[name="22772614-9929-4697-af17-d332a8cef12d"]',
            'css-hover' => 'a[name="22772614-9929-4697-af17-d332a8cef12d"]:hover',
            'button_action' => [
                'form',
                'test-drive-new',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="22772614-9929-4697-af17-d332a8cef12d"]',
                    'values' => array(
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
),
],
],
            'styles' => array(
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6E6F74,#6E6F74)',
                        'border-color' => '6E6F74',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#56575A,#56575A)',
                        'border-color' => '56575A',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED775B,#ED775B)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D36A51,#D36A51)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B20000,#B20000)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0097CE,#0097CE)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0084B4,#0084B4)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
        //        'trade-in' => [
        //            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => '[name="a1b00c94-4932-4ee2-9f9c-e3d0813ddf7c"]',
        //            'css-class' => '[name="a1b00c94-4932-4ee2-9f9c-e3d0813ddf7c"]',
        //            'css-hover' => '[name="a1b00c94-4932-4ee2-9f9c-e3d0813ddf7c"]:hover',
        //            'button_action' => [
        //                'form',
        //                'trade-in-new',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'trade-in' => [
        //                    'target' => '[name="a1b00c94-4932-4ee2-9f9c-e3d0813ddf7c"]',
        //                    'values' => array(
        //                        'Value Your Trade',
        //                        'We\'ll Buy Your Car',
        //                        'TRADE-IN OFFER',
        //                        'Trade In Your Ride',
        //                        'We Want Your Car',
        //                        'What\'s Your Trade Worth?',
        //                        'Trade Offer',
        //                        'Trade-In Your Ride',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#ED775B,#ED775B)',
        //                        'border-color' => '#f06b20',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#D36A51,#D36A51)',
        //                        'border-color' => '#cf540e',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#CC0000,#CC0000)',
        //                        'border-color' => '#e01212',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#B20000,#B20000)',
        //                        'border-color' => '#c60c0d',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#0097CE,#0097CE)',
        //                        'border-color' => '#1ca0d1',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#0084B4,#0084B4)',
        //                        'border-color' => '#188bb7',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'grey' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#6E6F74,#6E6F74)',
        //                        'border-color' => '#6E6F74',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#56575A,#56575A)',
        //                        'border-color' => '#56575A',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //            ),
        //        ],
        //watch price//
        'price-watch' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => [
                'form',
                'e-price-new',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'price-watch' => [
                    'target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
                    'values' => array(
                        'Watch Price',
                        'Watch This Price',
                        'Price Watch',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
                        'Get Price Alerts',
                        'Get Price Updates',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED775B,#ED775B)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D36A51,#D36A51)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B20000,#B20000)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0097CE,#0097CE)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0084B4,#0084B4)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6E6F74,#6E6F74)',
                        'border-color' => '6E6F74',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#56575A,#56575A)',
                        'border-color' => '56575A',
                        'color' => '#fff',
),
),
),
],
],
);