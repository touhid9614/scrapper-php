<?php

global $CronConfigs;
$CronConfigs["rayskillmanmazdawest"] = array(
    "name" => " rayskillmanmazdawest",
    "email" => "regan@smedia.ca",
    "password" => " rayskillmanmazdawest",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "rayskillmanmazdawest",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
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
            '#EA7027',
            '#EA7027',
),
        'button_color_hover' => array(
            '#9D4C1C',
            '#9D4C1C',
),
        'button_color_active' => array(
            '#9D4C1C',
            '#9D4C1C',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 Off Purchase of New Vehicle',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ray Skillman Westside Mazda',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@skillmanautomall.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Ray Skillman Westside Mazda"></id>
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
						<name part="full">Ray Skillman Westside Mazda</name>
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
            'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'adf_to' => array(
        'leads@skillmanautomall.motosnap.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.voi-link-vdp div',
            'css-class' => 'div.voi-link-vdp div',
            'css-hover' => 'div.voi-link-vdp div:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.voi-link-vdp div',
                    'values' => array(
                        'Get A Quote',
                        'Inquire Today',
                        'Lock This Price',
                        'Request A Quote',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EF7228,#EF7228)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BB591F,#BB591F)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#981A1E,#981A1E)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#711416,#711416)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006200,#006200)',
                        'border-color' => '359D22',
),
),
),
],
],
);