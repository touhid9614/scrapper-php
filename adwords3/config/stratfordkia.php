<?php

global $CronConfigs;
$CronConfigs["stratfordkia"] = array(
    "name" => " stratfordkia",
    "email" => "regan@smedia.ca",
    "password" => " stratfordkia",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "customer_id" => "809-360-2439",
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
        'youtube' => 0,
),
    'bing_account_id' => 156002928,
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
    "banner" => array(
        "template" => "stratfordkia",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_marketplace_description" => "[description]",
        "fb_marketplace_title" => "[year] [make] [model] [kilometres] km",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_style" => "facebook_new_ad",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
            '#BB162B',
            '#BB162B',
),
        'button_color_hover' => array(
            '#0A0A0A',
            '#0A0A0A',
),
        'button_color_active' => array(
            '#0A0A0A',
            '#0A0A0A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Special offer from Stratford Kia',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Stratford Kia Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'trader@stratfordkia.net',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Stratford Kia"></id>
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
						<name part="full">Stratford Kia</name>
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
        'trader@stratfordkia.net',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.button-group__button',
            'css-class' => '.button-group__button',
            'css-hover' => '.button-group__button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.button-group__button',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
),
],
],
);