<?php

global $CronConfigs;
$CronConfigs["pgmotors"] = array(
    'password' => 'pgmotors',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    'max_cost' => 0,
    'cost_distribution' => [
        'adwords' => 0,
],
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#3296CD',
            '#3296CD',
),
        'button_color_hover' => array(
            '#2CB450',
            '#2CB450',
),
        'button_color_active' => array(
            '#891C1D',
            '#891C1D',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $500 OFF COUPON from Prince George Ford',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Prince George Ford Team',
        'forward_to' => array(
            'leads@princegeorge.motosnap.com',
            'cpearson@pgmotors.ca',
            'jcallaghan@pgmotors.ca',
            'lyndseys@pgmotors.ca',
            'marshal@smedia.ca',
            'tayler@smedia.ca',
),
        'special_to' => array(
            'leads@princegeorge.motosnap.com',
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
							<name part="full">Prince George Ford</name>
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
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
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
    'customer_id' => ' 620-642-0432',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "pgmotors",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'leads@princegeorge.motosnap.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1',
    'buttons_live' => true,
    'buttons' => [
        'listing-request-a-quote' => [
            'url-match' => '/\\/vehicles\\/(?:new|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div a.gtm_vehicle_tile_cta.modal-trigger.button',
            'css-class' => 'div a.gtm_vehicle_tile_cta.modal-trigger.button',
            'css-hover' => 'div a.gtm_vehicle_tile_cta.modal-trigger.button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'listing-request-a-quote' => [
                    'target' => 'div a.gtm_vehicle_tile_cta.modal-trigger.button',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Now',
                        'Get E-Price',
                        'Special Pricing',
                        'Current Market Price',
                        'Get Internet Price',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB5A41,#CB5A41)',
                        'border-color' => 'CB5A41',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE4D34,#BE4D34)',
                        'border-color' => 'BE4D34',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6B9740,#6B9740)',
                        'border-color' => '6B9740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6B9740,#6B9740)',
                        'border-color' => '6B9740',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3396CD,#3396CD)',
                        'border-color' => '3396CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D87B9,#2D87B9)',
                        'border-color' => '2D87B9',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A50408,#A50408)',
                        'border-color' => 'A50408',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8C0307,#8C0307)',
                        'border-color' => '8C0307',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#292929,#292929)',
                        'border-color' => '292929',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-9 a',
            'css-class' => '#vdp_button_widget-9 a',
            'css-hover' => '#vdp_button_widget-9 a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '#vdp_button_widget-9 a',
                    'values' => array(
                        'Current Market Price',
                        'Get a Quote',
                        'Inquire Now',
                        'Request a Quote',
                        'Get Our Best Price',
                        'Special Pricing',
                        'Get Manager\'s Best E-Price',
                        'Get Manager\'s Best Internet Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB5A41,#CB5A41)',
                        'border-color' => 'CB5A41',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE4D34,#BE4D34)',
                        'border-color' => 'BE4D34',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3396CD,#3396CD)',
                        'border-color' => '3396CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D87B9,#2D87B9)',
                        'border-color' => '2D87B9',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6B9740,#6B9740)',
                        'border-color' => '6B9740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6B9740,#6B9740)',
                        'border-color' => '6B9740',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A50408,#A50408)',
                        'border-color' => 'A50408',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#8C0307,#8C0307)',
                        'border-color' => '8C0307',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#292929,#292929)',
                        'border-color' => '292929',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
),
),
],
],
);