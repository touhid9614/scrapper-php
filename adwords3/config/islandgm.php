<?php

global $CronConfigs;
$CronConfigs["islandgm"] = array(
    'password' => 'islandgm',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
        'youtube' => 0,
),
    "customer_id" => "641-326-8912",
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Come see the [year]",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[make] [model] today. \$5000 Prize Draw with Every Purchase!",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Come see the [year]",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[make] [model] today. \$5000 Prize Draw with Every Purchase!",
),
),
    //smart offer
    "lead" => array(
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
            '#F07F0A',
            '#F07F0A',
),
        'button_color_hover' => array(
            '#126AAE',
            '#126AAE',
),
        'button_color_active' => array(
            '#126AAE',
            '#126AAE',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $25 Gas Card coupon from Island GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Island GM Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@islandgm.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
				<?adf version="1.0"?>
					<adf>
						<prospect>
							<id sequence="[total_count]" source="Island GM"></id>
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
								<name part="full">Island GM</name>
								<email>[dealer_email]</email>
							</contact>
						</vendor>
						<provider>
							<name part="full">sMedia Coupon</name>
							<url>http://smedia.ca</url>
							<email>offers@mail.smedia.ca</email>
							<phone>855-775-0062</phone>
						</provider>
						</prospect>
					</adf>',
        'display_after' => 60000,
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
            'vdp' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service' => '',
),
),
    //dynamic ads
    "banner" => array(
        "template" => "islandgm",
        'fb_description' => "Are you still interested in a [year] [make] [model]? Click for more information.",
        'fb_lookalike_description' => "Test drive the [year] [make] [model] today! Click for more information.",
        'fb_dynamiclead_description' => "Are you still interested in the [year] [make] [model]? Click below, fill in your information, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "params" => array(
            "show_stock" => 'yes',
),
        "fb_style" => "facebook_new_ad",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Market Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '3585CB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '276499',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '48E62F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '2D6525',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '772B31',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '772B31',
),
),
),
],
        'book-test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.links-list.ddc-content.restricted a:nth-of-type(3)',
            'css-class' => 'div.links-list.ddc-content.restricted a:nth-of-type(3)',
            'css-hover' => 'div.links-list.ddc-content.restricted a:nth-of-type(3):hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.links-list.ddc-content.restricted a:nth-of-type(3)',
                    'values' => array(
                        'Schedule Test Drive',
                        'Schedule Your Visit',
                        'Test Drive Now',
                        'Want to Test Drive It?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '3585CB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '276499',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '48E62F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '2D6525',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '772B31',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '772B31',
),
),
),
],
        'request-test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'ul.has-eprice a[data-href*=testdrive]',
            'css-class' => 'ul.has-eprice a[data-href*=testdrive]',
            'css-hover' => 'ul.has-eprice a[data-href*=testdrive]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'ul.has-eprice a[data-href*=testdrive]',
                    'values' => array(
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Request Test Drive',
                        'Schedule Your Visit',
                        'Test Drive Now',
                        'Test Drive Today',
                        'Want to Test Drive It?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '3585CB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '276499',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '48E62F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '2D6525',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '772B31',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '772B31',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.links-list.ddc-content.restricted a:nth-of-type(2)',
            'css-class' => 'div.links-list.ddc-content.restricted a:nth-of-type(2)',
            'css-hover' => 'div.links-list.ddc-content.restricted a:nth-of-type(2):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'div.links-list.ddc-content.restricted a:nth-of-type(2)',
                    'values' => array(
                        'Get More Info',
                        'Request More Info',
                        'Let Our Experts Help',
                        'More Info',
                        'Learn More',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '3585CB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '276499',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '48E62F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '2D6525',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '772B31',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '772B31',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=financing].btn',
            'css-class' => 'a[href*=financing].btn',
            'css-hover' => 'a[href*=financing].btn:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing].btn',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Special Finance Offers!',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '3585CB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '276499',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '48E62F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '2D6525',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '772B31',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => 'FB3342',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '772B31',
),
),
),
],
],
);