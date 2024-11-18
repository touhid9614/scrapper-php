<?php

global $CronConfigs;
$CronConfigs["mcdonaldchevrolet"] = array(
    "name" => " mcdonaldchevrolet",
    "email" => "regan@smedia.ca",
    "password" => " mcdonaldchevrolet",
    "log" => true,
    'customer_id' => '168-028-4295',
    'max_cost' => 300,
    'cost_distribution' => array(
        'adwords' => 300,
),
    "banner" => array(
        "template" => "mcdonaldchevrolet",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
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
            '#F2BF24',
            '#F2BF24',
),
        'button_color_hover' => array(
            '#393839',
            '#393839',
),
        'button_color_active' => array(
            '#393839',
            '#393839',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 off coupon from McDonald Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>McDonald Chevrolet Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'andrewsj@Quorumdms.com',
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
						<name part="full">McDonald Chevrolet Buick GMC Ltd</name>
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
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => '.inventory-vehicle-infos__prices-link-wrapper a',
            'css-class' => '.inventory-vehicle-infos__prices-link-wrapper a',
            'css-hover' => '.inventory-vehicle-infos__prices-link-wrapper a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.inventory-vehicle-infos__prices-link-wrapper a',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5C9E,#2A5C9E)',
                        'border-color' => '2A5C9E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#680E08,#680E08)',
                        'border-color' => '680E08',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F2BF24,#F2BF24)',
                        'border-color' => 'F2BF24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD961F,#BD961F)',
                        'border-color' => 'BD961F',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016E2D,#016E2D)',
                        'border-color' => '016E2D',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *="/en/form/road-test',
            'css-class' => 'a[href *="/en/form/road-test',
            'css-hover' => 'a[href *="/en/form/road-test:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href *=road-test]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5C9E,#2A5C9E)',
                        'border-color' => '2A5C9E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#680E08,#680E08)',
                        'border-color' => '680E08',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F2BF24,#F2BF24)',
                        'border-color' => 'F2BF24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD961F,#BD961F)',
                        'border-color' => 'BD961F',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016E2D,#016E2D)',
                        'border-color' => '016E2D',
                        'color' => '#fff',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *="trade-in"]',
            'css-class' => 'a[href *="trade-in"]',
            'css-hover' => 'a[href *="trade-in"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href *="trade-in"]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5C9E,#2A5C9E)',
                        'border-color' => '2A5C9E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#680E08,#680E08)',
                        'border-color' => '680E08',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F2BF24,#F2BF24)',
                        'border-color' => 'F2BF24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD961F,#BD961F)',
                        'border-color' => 'BD961F',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016E2D,#016E2D)',
                        'border-color' => '016E2D',
                        'color' => '#fff',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|certified|used)-inventory\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=financing-request]',
            'css-class' => 'a[href *=financing-request]',
            'css-hover' => 'a[href *=financing-request]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href *=financing-request]',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5C9E,#2A5C9E)',
                        'border-color' => '2A5C9E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#680E08,#680E08)',
                        'border-color' => '680E08',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F2BF24,#F2BF24)',
                        'border-color' => 'F2BF24',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BD961F,#BD961F)',
                        'border-color' => 'BD961F',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016E2D,#016E2D)',
                        'border-color' => '016E2D',
                        'color' => '#fff',
),
),
),
],
],
);