<?php

global $CronConfigs;
$CronConfigs["guychevy"] = array(
    "name" => " guychevy",
    "email" => "regan@smedia.ca",
    "password" => " guychevy",
    "log" => true,
    "banner" => array(
        "template" => "guychevy",
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
            '#CE287E',
            '#CE287E',
),
        'button_color_hover' => array(
            '#A32064',
            '#A32064',
),
        'button_color_active' => array(
            '#A32064',
            '#A32064',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Guy Chevrolet Company',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Guy Chevy Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@guychevy.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Guy Chevrolet Company"></id>
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
						<name part="full">Guy Chevrolet Company</name>
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
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
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
            'action-target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#74100A,#74100A)',
                        'border-color' => '74100A',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2E3192,#2E3192)',
                        'border-color' => '2E3192',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#252773,#252773)',
                        'border-color' => '252773',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D18905,#D18905)',
                        'border-color' => 'D18905',
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
            'action-target' => '[name="e022323f-ccc0-4a96-9bba-2a7179dbc245"]',
            'css-class' => '[name="e022323f-ccc0-4a96-9bba-2a7179dbc245"]',
            'css-hover' => '[name="e022323f-ccc0-4a96-9bba-2a7179dbc245"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="e022323f-ccc0-4a96-9bba-2a7179dbc245"]',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#74100A,#74100A)',
                        'border-color' => '74100A',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2E3192,#2E3192)',
                        'border-color' => '2E3192',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#252773,#252773)',
                        'border-color' => '252773',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D18905,#D18905)',
                        'border-color' => 'D18905',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="88e8019a-281c-49c1-9dd2-66ff0210269d"]',
            'css-class' => '[name="88e8019a-281c-49c1-9dd2-66ff0210269d"]',
            'css-hover' => '[name="88e8019a-281c-49c1-9dd2-66ff0210269d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '[name="88e8019a-281c-49c1-9dd2-66ff0210269d"]',
                    'values' => array(
                        'Call Us Now',
                        'Call Us Today',
                        'Contact Us Now',
                        'Contact Us Today',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#74100A,#74100A)',
                        'border-color' => '74100A',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2E3192,#2E3192)',
                        'border-color' => '2E3192',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#252773,#252773)',
                        'border-color' => '252773',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D18905,#D18905)',
                        'border-color' => 'D18905',
),
),
),
],
],
);