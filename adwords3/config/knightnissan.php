<?php

global $CronConfigs;
$CronConfigs["knightnissan"] = array(
    'name' => 'knightnissan',
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'knightnissan',
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 600,
    'cost_distribution' => array(
        'new' => 343,
        'used' => 257,
),
    "email" => "regan@smedia.ca",
    'bing_account_id' => 156002892,
    //tracker
    'log' => true,
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_combined" => yes,
        "new_combined" => yes,
),
    "post_code" => "s9h 0b5",
    //Max lenght 35 char
    "new_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    "customer_id" => "116-175-7758",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "knightnissan",
        'fb_marketplace_description' => '[description]',
        //'fb_retargeting_description_new' => "Are you still interested in the [year] [make] [model]? Show us your quote on the same vehicle from any other Nissan dealership and Knight Nissan will Beat their Price GUARANTEED! Free delivery anywhere in Saskatchewan.",
        'fb_retargeting_description_new' => "Are you still interested in the [year] [make] [model]? Shop from the comfort of your own home!",
        'fb_retargeting_description_used' => "Get competitive price on the [year] [make] [model]. Shop from the comfort of your own home!",
        //"fb_lookalike_description_new" => "Check out this [year] [make] [model] today. Show us your quote on the same vehicle from any other Nissan dealership and Knight Nissan will Beat their Price GUARANTEED! Free delivery anywhere in Saskatchewan.",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] today. Shop from the comfort of your own home!",
        "fb_lookalike_description_used" => "Check out this [year] [make] [model] today. Shop from the comfort of your own home!",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#000",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#000000",
),
    'adf_to' => array(
        'leads@knightnissan.co',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
            'css-class' => 'a.button.cta-button.block.button-form.fancybox',
            'css-hover' => 'a.button.cta-button.block.button-form.fancybox:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'You are Eligible for Special Pricing',
                        'Special Pricing!',
                        'Get Your Best Price',
                        'Get Special Price',
                        'Get Sale Price',
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
    'lead' => array(
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
            '#D32330',
            '#D32330',
),
        'button_color_hover' => array(
            '#A71C26',
            '#A71C26',
),
        'button_color_active' => array(
            '#A71C26',
            '#A71C26',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Request A Video Tour of Your Vehicle of Interest',
        'response_email' => 'Hello [name],<p> Thank you for signing up for this offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Knight Nissan Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@knightnissan.co',
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
					<vendorname>Knight Nissan</vendorname>
					<contact>
						<name part="full">Knight Nissan</name>
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
            'vdp' => '/\\/(?:new|used|certified)-[0-9]{4}-/i',
            'service' => '',
),
),
);