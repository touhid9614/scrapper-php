<?php

global $CronConfigs;
$CronConfigs["varsitychrysler"] = array(
    "name" => " varsitychrysler",
    "email" => "regan@smedia.ca",
    "password" => " varsitychrysler",
    "log" => true,
    'max_cost' => 500,
    'bing_account_id' => 156003301,
    'cost_distribution' => array(
        'adwords' => 500,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
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
    "customer_id" => "589-476-7401",
    "banner" => array(
        "template" => "varsitychrysler",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
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
            '#005EAB',
            '#005EAB',
),
        'button_color_hover' => array(
            '#0C64BD',
            '#094584',
),
        'button_color_active' => array(
            '#094584',
            '#094584',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 off coupon from Varsity Chrysler Dodge Jeep Ram',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Varsity CDJR Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'avincent@varistychrysler.ca',
),
        'special_to' => array(
            'varsitysales@varsitychrysler.net',
            'leads@varsitychrysler.net',
            'tamissy13@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Varsity Chrysler Dodge Jeep Ram"></id>
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
						<name part="full">Varsity Chrysler Dodge Jeep Ram</name>
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
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button-group__button.modal-trigger.button.button--centered',
            'css-class' => 'a.button-group__button.modal-trigger.button.button--centered',
            'css-hover' => 'a.button-group__button.modal-trigger.button.button--centered:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button-group__button.modal-trigger.button.button--centered',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
                        'Request Walk-Around Video',
                        'Request Video Tour',
                        'Virtual Vehicle Walk-Around',
                        'Get Your Digital Tour',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'FF0000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC0303,#DC0303)',
                        'border-color' => 'DC0303',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#045EB1,#045EB1)',
                        'border-color' => '045EB1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#044B8C,#044B8C)',
                        'border-color' => '044B8C',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#39811B,#39811B)',
                        'border-color' => '39811B',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2F6817,#2F6817)',
                        'border-color' => '2F6817',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=test-drive].button',
            'css-class' => 'a[href *=test-drive].button',
            'css-hover' => 'a[href *=test-drive].button:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href *=test-drive].button',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Schedule Virtual Test Drive',
                        'Schedule At-Home Test Drive',
                        'Virtual Test Drive',
                        'At-Home Test Drive',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'FF0000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC0303,#DC0303)',
                        'border-color' => 'DC0303',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#045EB1,#045EB1)',
                        'border-color' => '045EB1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#044B8C,#044B8C)',
                        'border-color' => '044B8C',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#39811B,#39811B)',
                        'border-color' => '39811B',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2F6817,#2F6817)',
                        'border-color' => '2F6817',
                        'color' => '#fff',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=instant-trade-value].button',
            'css-class' => 'a[href *=instant-trade-value].button',
            'css-hover' => 'a[href *=instant-trade-value].button:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href *=instant-trade-value].button',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'FF0000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC0303,#DC0303)',
                        'border-color' => 'DC0303',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#045EB1,#045EB1)',
                        'border-color' => '045EB1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#044B8C,#044B8C)',
                        'border-color' => '044B8C',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#39811B,#39811B)',
                        'border-color' => '39811B',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2F6817,#2F6817)',
                        'border-color' => '2F6817',
                        'color' => '#fff',
),
),
),
],
],
);