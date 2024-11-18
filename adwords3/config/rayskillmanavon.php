<?php

global $CronConfigs;
$CronConfigs["rayskillmanavon"] = array(
    "name" => " rayskillmanavon",
    "email" => "regan@smedia.ca",
    "password" => " rayskillmanavon",
    "log" => true,
    "banner" => array(
        "template" => "rayskillmanavon",
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
            '#004B8D',
            '#004B8D',
),
        'button_color_hover' => array(
            '#00305A',
            '#00305A',
),
        'button_color_active' => array(
            '#00305A',
            '#00305A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '/$250 off coupon from Ray Skillman Avon Hyundai',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ray Skillman Avon Hyundai Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@rayskillmanhyundaiavon.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Ray Skillman Avon Hyundai"></id>
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
						<name part="full">Ray Skillman Avon Hyundai</name>
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
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'service' => '',
),
),
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.pay-calc-link-vdp div',
            'css-class' => 'div.pay-calc-link-vdp div',
            'css-hover' => 'div.pay-calc-link-vdp div:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.pay-calc-link-vdp div',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Get Approved Today',
                        'Financing Available',
                        'Special Finance Offers',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9B1B1E,#9B1B1E)',
                        'border-color' => '9B1B1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#871719,#871719)',
                        'border-color' => '871719',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '008B00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016A01,#016A01)',
                        'border-color' => '016A01',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '325387',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21385D,#21385D)',
                        'border-color' => '21385D',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.voi-btn-vdp.voi-icon-bounce-vdp',
            'css-class' => 'div.voi-btn-vdp.voi-icon-bounce-vdp',
            'css-hover' => 'div.voi-btn-vdp.voi-icon-bounce-vdp:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.voi-btn-vdp.voi-icon-bounce-vdp',
                    'values' => array(
                        'Get Special Pricing',
                        'Get More Details',
                        'Ask for More Info',
                        'Request More Info',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9B1B1E,#9B1B1E)',
                        'border-color' => '9B1B1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#871719,#871719)',
                        'border-color' => '871719',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '008B00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016A01,#016A01)',
                        'border-color' => '016A01',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '325387',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21385D,#21385D)',
                        'border-color' => '21385D',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.trade-link-vdp div',
            'css-class' => 'div.trade-link-vdp div',
            'css-hover' => 'div.trade-link-vdp div:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.trade-link-vdp div',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9B1B1E,#9B1B1E)',
                        'border-color' => '9B1B1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#871719,#871719)',
                        'border-color' => '871719',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '008B00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#016A01,#016A01)',
                        'border-color' => '016A01',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#325387,#325387)',
                        'border-color' => '325387',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21385D,#21385D)',
                        'border-color' => '21385D',
),
),
),
],
],
);