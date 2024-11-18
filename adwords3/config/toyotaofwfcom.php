<?php

global $CronConfigs;
$CronConfigs["toyotaofwfcom"] = array(
    "name" => " toyotaofwfcom",
    "email" => "regan@smedia.ca",
    "password" => " toyotaofwfcom",
    "log" => true,
    "lead" => array(
        'live' => true,
        'lead_type_' => false,
        'lead_type_new' => true,
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
        'response_email_subject' => '$200 off coupon from Toyota of Wichita Falls',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Toyota of WF Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@towfsales.com',
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
					<vendorname>Toyota of Wichita Falls</vendorname>
					<contact>
						<name part="full">Toyota of Wichita Falls</name>
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
    'adf_to' => '',
    'form_live' => false,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'button[href*=eprice-form]',
            'css-class' => 'button[href*=eprice-form]',
            'css-hover' => 'button[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button[href*=eprice-form]s',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1676B4,#1676B4)',
                        'border-color' => '1676B4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#115C8C,#115C8C)',
                        'border-color' => '115C8C',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F01B32,#F01B32)',
                        'border-color' => 'F01B32',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C11729,#C11729)',
                        'border-color' => 'C11729',
),
),
),
],
],
);