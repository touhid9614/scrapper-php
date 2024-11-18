<?php

global $CronConfigs;
$CronConfigs["trimactoyota"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'password' => 'trimactoyota',
    'post_code' => 'E2A 7K2',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "email" => "regan@smedia.ca",
    /*smart offer*/
    "lead" => array(
        'live' => true,
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
            '#EE1A30',
            '#EE1A30',
),
        'button_color_hover' => array(
            '#C60F22',
            '#C60F22',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Sign Up for FREE At Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Trimac Toyota Team',
        'forward_to' => array(
            'mark@trimac.toyota.ca',
            'sales@trimac.toyota.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            '',
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
					<vendorname>Dealership Name</vendorname>
					<contact>
						<name part="full">Dealership Name</name>
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
            'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
            'service' => '',
),
),
    /*system ads*/
    "banner" => array(
        "template" => "trimactoyota",
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
    'lead_to' => array(
        'sales@trimac.toyota.ca',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified)\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.accordion-opener.btn.btn-primary',
            'css-class' => 'a.accordion-opener.btn.btn-primary',
            'css-hover' => 'a.accordion-opener.btn.btn-primary:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.accordion-opener.btn.btn-primary',
                    'values' => array(
                        'REQUEST INFO',
                        'ASK A QUESTION',
                        'Learn More',
                        'More Information',
                        'E-price',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F69A1B,#F69A1B)',
                        'border-color' => 'F69A1B',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#945806,#945806)',
                        'border-color' => '945806',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE1A30,#EE1A30)',
                        'border-color' => 'EE1A30',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#870A17,#870A17)',
                        'border-color' => '870A17',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20A704,#20A704)',
                        'border-color' => '20A704',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#136502,#136502)',
                        'border-color' => '136502',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B639F,#1B639F)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C2D48,#0C2D48)',
                        'border-color' => '0C2D48',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#827A65,#827A65)',
                        'border-color' => '0C2D48',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006994,#006994)',
                        'border-color' => '0C2D48',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified)\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.accordion-opener.btn.btn-secondary',
            'css-class' => 'a.accordion-opener.btn.btn-secondary',
            'css-hover' => 'a.accordion-opener.btn.btn-secondary:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.accordion-opener.btn.btn-secondary',
                    'values' => array(
                        'Request a Test Drive',
                        'Test Drive Today',
                        'Schedule My Visit',
                        'TEST RIDE',
                        'SCHEDULE MY TEST DRIVE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F69A1B,#F69A1B)',
                        'border-color' => 'F69A1B',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#945806,#945806)',
                        'border-color' => '945806',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE1A30,#EE1A30)',
                        'border-color' => 'EE1A30',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#870A17,#870A17)',
                        'border-color' => '870A17',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20A704,#20A704)',
                        'border-color' => '20A704',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#136502,#136502)',
                        'border-color' => '136502',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B639F,#1B639F)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C2D48,#0C2D48)',
                        'border-color' => '0C2D48',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#827A65,#827A65)',
                        'border-color' => '0C2D48',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1B639F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006994,#006994)',
                        'border-color' => '0C2D48',
),
),
),
],
],
);