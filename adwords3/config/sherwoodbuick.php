<?php

global $CronConfigs;
$CronConfigs["sherwoodbuick"] = array(
    'password' => 'sherwoodbuick',
    "email" => "regan@smedia.ca",
    'snapchat_image_index' => 3,
    'log' => true,
    'tag_debug' => false,
    'bing_account_id' => 156003002,
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
            '#D90032',
            '#D90032',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'get 6 months payment defferals',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sherwood Buick GMC Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@sherwoodbuickgmc.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Sherwood Buick GMC Team"></id>
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
						<name part="full">Sherwood Buick GMC Team</name>
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
            'vdp' => '/inventory\\/(?:new|used|certified|certified-used)-[0-9]{4}-/',
            'service' => '',
),
),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "sherwoodbuick",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info! Stock #: [stock_number].",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information. Stock #: [stock_number].",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        'snapchat_image_index' => 2,
),
    'adf_to' => array(
        'leads@sherwoodbuickgmc.motosnap.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'form_disclaimer' => '<h5 style="display: inline; font-weight: bold">Qualified customers will receive an additional</h5><h3 style="display: inline; font-weight: bold">&nbsp;$600 off&nbsp;</h3><h5 style="display: inline; font-weight: bold">this vehicle!*</h5><br><br> <h6>*A customer is qualified by submitting both a valid phone number & email address.</h6>',
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form].btn',
            'css-class' => 'a[href*=eprice-form].btn',
            'css-hover' => 'a[href*=eprice-form].btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form].btn',
                    'values' => array(
                        'Local Pricing',
                        'Best Price',
                        'GET CURRENT MARKET PRICE',
                        'Get Internet Price Now',
                        'GET E-PRICE',
                        'Get your Price!',
                        'Get Your Exclusive Price',
                        'Local Pricing',
                        'Exclusive Pricing',
                        'Get our best price!',
                        'Buy From Home!',
                        'Purchase from Home',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'orange' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'color' => '#ffffff',
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