<?php

global $CronConfigs;
$CronConfigs["southtrailnissanca"] = array(
    "name" => " southtrailnissanca",
    "email" => "regan@smedia.ca",
    "password" => " southtrailnissanca",
    "log" => true,
    'bing_account_id' => 156003300,
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
    "customer_id" => "469-035-5393",
    "banner" => array(
        "template" => "southtrailnissanca",
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
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#1E4387',
            '#1E4387',
),
        'button_color_hover' => array(
            '#1A3972',
            '#1A3972',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from South Trail Nissan',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>South Trail Nissan Team',
        'forward_to' => array(
            'abui@southtrailnissan.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@southtrailnissan.ca',
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
					<vendorname>South Trail Nissan</vendorname>
					<contact>
						<name part="full">South Trail Nissan</name>
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
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service' => '',
),
),
    'adf_to' => '',
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-class' => '.button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-hover' => '.button-group__button.button.button--alternate.button--centered.modal-trigger:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.button-group__button.button.button--alternate.button--centered.modal-trigger',
                    'values' => array(
                        'Schedule Virtual Test Drive',
                        'Schedule At-Home Test Drive',
                        'Virtual Test Drive',
                        'At-Home Test Drive',
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
                        'background' => 'linear-gradient(#C4253D,#C4253D)',
                        'border-color' => 'C4253D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8F1D2E,#8F1D2E)',
                        'border-color' => '8F1D2E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#28A900,#28A900)',
                        'border-color' => '28A900',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1F8201,#1F8201)',
                        'border-color' => '1F8201',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0D65BF,#0D65BF)',
                        'border-color' => '0D65BF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0B4D90,#0B4D90)',
                        'border-color' => '0B4D90',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4253D,#C4253D)',
                        'border-color' => 'C4253D',
),
),
),
],
],
);