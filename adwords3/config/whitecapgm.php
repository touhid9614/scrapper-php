<?php

global $CronConfigs;
$CronConfigs["whitecapgm"] = array(
    'name' => 'Whitecap Chevrolet Buick GMC',
    'password' => 'whitecapgm',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 650.0,
    'cost_distribution' => array(
        'adwords' => 600,
        'youtube' => 0,
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
    "customer_id" => "722-757-6286",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "whitecapgm",
        "fb_description_new" => "Are you still interested in the [year] [make] [model]? MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. We are open and here to help with no contact options for buying and servicing your new vehicle. Amvic Licensed Dealership.",
        "fb_description" => "Are you still interested in the [year] [make] [model] Stock: [stock_number]? We are open and here to help with no contact options for buying and servicing your new vehicle. Amvic Licensed Dealership.",
        "fb_lookalike_description_new" => "Test drive the [year] [make] [model] today! MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. Amvic Licensed Dealership. Don't see what you want?  Let us know.",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today! Stock: [stock_number]. Amvic Licensed Dealership. Don't see what you want?  Let us know.",
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
            '#CC0033',
            '#CC0033',
),
        'button_color_hover' => array(
            '#990026',
            '#990026',
),
        'button_color_active' => array(
            '#990026',
            '#990026',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Sign up for FREE At-Home Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Jack Dewald <br> General Sales Manager <br> Whitecap Chevrolet Buick GMC',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            '1224wcapsalesleads11@dealermineinc.com',
            'crm@whitecapgm.com',
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
					<vendorname>Whitecap GM</vendorname>
					<contact>
						<name part="full">Whitecap GM</name>
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
    'buttons_live' => true,
    'form_live' => false,
    'lead_to' => [
        'JGongos@whitecapgm.ca',
        'jdewald@whitecapgm.ca',
],
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="f6059346-53e2-4d97-a897-9feb1e3d5934"]',
            'css-class' => 'a[name="f6059346-53e2-4d97-a897-9feb1e3d5934"]',
            'css-hover' => 'a[name="f6059346-53e2-4d97-a897-9feb1e3d5934"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="f6059346-53e2-4d97-a897-9feb1e3d5934"]',
                    'values' => array(
                        'More Information',
                        'More Info',
                        'Get Price Updates',
                        'Price Updates',
                        'Get Details',
                        'More Details',
                        'Check Availability',
                        'See Availability',
                        'Is this available?',
                        'Click for Availability',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
);