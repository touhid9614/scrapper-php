<?php

global $CronConfigs;
$CronConfigs["prioritytoyotaspringfield"] = array(
    "name" => " prioritytoyotaspringfield",
    "email" => "regan@smedia.ca",
    "password" => " prioritytoyotaspringfield",
    "log" => true,
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
            '#D71920',
            '#D71920',
),
        'button_color_hover' => array(
            '#343434',
            '#343434',
),
        'button_color_active' => array(
            '#343434',
            '#343434',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Priority Toyota Springfield',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Priority Toyota Springfield Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'emil@smedia.ca',
),
        'special_to' => array(
            'prioritytoyotaspringfield@eleadtrack.net',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="sMedia :: Smart Offer"></id>
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
							<name part="full">Priority Toyota Springfield</name>
							<email>[dealer_email]</email>
						</contact>
					</vendor>
					<provider>
                        <name part="full">sMedia</name>
                        <service>Smart Offer</service>
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
    "banner" => array(
        "template" => "prioritytoyotaspringfield",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'prioritytoyotaspringfield@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/vehicle\\/(?:new|used)-[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a#get_approved_button',
            'css-class' => 'a#get_approved_button',
            'css-hover' => 'a#get_approved_button:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a#get_approved_button',
                    'values' => array(
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Financing Options',
                        'Second Chance Financing!',
                        'Re-establish your credit',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicle\\/(?:new|used)-[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.buy-btn-section a[href*=trade-value]',
            'css-class' => '.buy-btn-section a[href*=trade-value]',
            'css-hover' => '.buy-btn-section a[href*=trade-value]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '.buy-btn-section a[href*=trade-value]',
                    'values' => array(
                        'Get Trade-In Value',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
),
],
],
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17601',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);