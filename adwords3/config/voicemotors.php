<?php

global $CronConfigs;
$CronConfigs["voicemotors"] = array(
    "name" => " voicemotors",
    "email" => "regan@smedia.ca",
    "password" => " voicemotors",
    "log" => true,
    "banner" => array(
        "template" => "voicemotors",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
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
            '#B20F15',
            '#B20F15',
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
        'response_email_subject' => '$200 off coupon from Voice Motor Sales',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Voice Motor Sales Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'sales@voicemotors.com',
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
						<name part="full">Voice Motor Sales</name>
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
            'vdp' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}/i',
            'service' => '',
),
),
    'adf_to' => array(
        '',
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
            'action-target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Today\'s Quote!',
                        'Get Quote',
                        'Ask for a Quote',
                        'Get A Quote',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9735,#CD9735)',
                        'border-color' => 'CD9735',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A4792A,#A4792A)',
                        'border-color' => 'A4792A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C01315,#C01315)',
                        'border-color' => 'C01315',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#931012,#931012)',
                        'border-color' => '931012',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#506D1B,#506D1B)',
                        'border-color' => '506D1B',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#406000,#406000)',
                        'border-color' => '406000',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005CA9,#005CA9)',
                        'border-color' => '005CA9',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#024E8E,#024E8E)',
                        'border-color' => '024E8E',
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
            'action-target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
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
                        'background' => 'linear-gradient(#CD9735,#CD9735)',
                        'border-color' => 'CD9735',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A4792A,#A4792A)',
                        'border-color' => 'A4792A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C01315,#C01315)',
                        'border-color' => 'C01315',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#931012,#931012)',
                        'border-color' => '931012',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#506D1B,#506D1B)',
                        'border-color' => '506D1B',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#406000,#406000)',
                        'border-color' => '406000',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005CA9,#005CA9)',
                        'border-color' => '005CA9',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#024E8E,#024E8E)',
                        'border-color' => '024E8E',
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
            'action-target' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
            'css-class' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
            'css-hover' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[name="7aa7056a-a135-467c-88cf-1135db9883eb"]',
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
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9735,#CD9735)',
                        'border-color' => 'CD9735',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A4792A,#A4792A)',
                        'border-color' => 'A4792A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C01315,#C01315)',
                        'border-color' => 'C01315',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#931012,#931012)',
                        'border-color' => '931012',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#506D1B,#506D1B)',
                        'border-color' => '506D1B',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#406000,#406000)',
                        'border-color' => '406000',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#005CA9,#005CA9)',
                        'border-color' => '005CA9',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#024E8E,#024E8E)',
                        'border-color' => '024E8E',
),
),
),
],
],
);