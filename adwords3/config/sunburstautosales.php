<?php

global $CronConfigs;
$CronConfigs["sunburstautosales"] = array(
    "name" => " sunburstautosales",
    "email" => "regan@smedia.ca",
    "password" => " sunburstautosales",
    "log" => true,
    "customer_id" => "541-253-2942",
    'max_cost' => 0,
    'cost_distribution' => array(),
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "sunburstautosales",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#252525',
            '#252525',
),
        'button_color_hover' => array(
            '#EE001E',
            '#EE001E',
),
        'button_color_active' => array(
            '#EE001E',
            '#EE001E',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 off coupon from Sunburst Auto',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sunburst Auto Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            '12050@dealercarsearchcrm.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Sunburst Auto Sales Center"></id>
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
						<name part="full">Sunburst Auto Sales Center</name>
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
    'log' => true,
    'adf_to' => array(
        '12050@dealercarsearchcrm.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/[0-9]{4}-[^\\/]+\\/(?:New|Used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.i10r_links a:nth-of-type(3)',
            'css-class' => 'div.i10r_links a:nth-of-type(3)',
            'css-hover' => 'div.i10r_links a:nth-of-type(3):hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.i10r_links a:nth-of-type(3)',
                    'values' => array(
                        '<i class="fa fa-edit"></i>Financing Options',
                        '<i class="fa fa-edit"></i>Get Financed Today',
                        '<i class="fa fa-edit"></i>Get Your Loan Online',
                        '<i class="fa fa-edit"></i>Apply for Financing',
                        '<i class="fa fa-edit"></i>Get Approved',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE001F,#EE001F)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#AD0017,#AD0017)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F6BE1C,#F6BE1C)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#362A06,#362A06)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#252525,#252525)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/[0-9]{4}-[^\\/]+\\/(?:New|Used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.i10r_links a:nth-of-type(4)',
            'css-class' => 'div.i10r_links a:nth-of-type(4)',
            'css-hover' => 'div.i10r_links a:nth-of-type(4):hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.i10r_links a:nth-of-type(4)',
                    'values' => array(
                        '<i class="fa fa-key"></i>Book Test Drive',
                        '<i class="fa fa-key"></i>Test Drive Now',
                        '<i class="fa fa-key"></i>Schedule a Test Drive',
                        '<i class="fa fa-key"></i>Schedule Your Test Drive',
                        '<i class="fa fa-key"></i>Request A Test Drive',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE001F,#EE001F)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#AD0017,#AD0017)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F6BE1C,#F6BE1C)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#362A06,#362A06)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#252525,#252525)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
),
],
],
);