<?php

global $CronConfigs;
$CronConfigs["royaloaknissan"] = array(
    "name" => " royaloaknissan",
    "email" => "regan@smedia.ca",
    "password" => " royaloaknissan",
    "log" => true,
    'bing_account_id' => 156003302,
    'max_cost' => 500,
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
    "customer_id" => "300-592-1886",
    "banner" => array(
        'template' => 'dealership',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
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
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#C10130",
            "#C10130",
),
        'button_color_hover' => array(
            "#000000",
            "#000000",
),
        'button_color_active' => array(
            "#000000",
            "#000000",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Royal Oak Nissan",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Royal Oak Nissan Team",
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'leads@royaloaknissan.ca',
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
						<name part="full">Royal Oak Nissan</name>
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
    'lead_to' => array(
        'leads@royaloaknissan.ca',
        'abui@royaloaknissan.ca',
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
            'action-target' => 'a[data-target*=vdp_button_widget-3-modal]',
            'css-class' => 'a[data-target*=vdp_button_widget-3-modal]',
            'css-hover' => 'a[data-target*=vdp_button_widget-3-modal]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-target*=vdp_button_widget-3-modal]',
                    'values' => array(
                        'Get Special Pricing',
                        'Get More Details',
                        'Ask for More Info',
                        'Request More Info',
                        'Request Walk-Around Video',
                        'Request Video Tour',
                        'Virtual Vehicle Walk-Around',
                        'Get Your Digital Tour',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0D65BF,#0D65BF)',
                        'border-color' => '0D65BF',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0B4D90,#0B4D90)',
                        'border-color' => '0B4D90',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28A900,#28A900)',
                        'border-color' => '28A900',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1F8201,#1F8201)',
                        'border-color' => '1F8201',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C4253D,#C4253D)',
                        'border-color' => 'C4253D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8F1D2E,#8F1D2E)',
                        'border-color' => '8F1D2E',
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
            'action-target' => 'a[data-target*=vdp_button_widget-4-modal]',
            'css-class' => 'a[data-target*=vdp_button_widget-4-modal]',
            'css-hover' => 'a[data-target*=vdp_button_widget-4-modal]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-target*=vdp_button_widget-4-modal]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0D65BF,#0D65BF)',
                        'border-color' => '0D65BF',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0B4D90,#0B4D90)',
                        'border-color' => '0B4D90',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28A900,#28A900)',
                        'border-color' => '28A900',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1F8201,#1F8201)',
                        'border-color' => '1F8201',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C4253D,#C4253D)',
                        'border-color' => 'C4253D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8F1D2E,#8F1D2E)',
                        'border-color' => '8F1D2E',
                        'color' => '#fff',
),
),
),
],
],
);