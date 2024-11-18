<?php

global $CronConfigs;
$CronConfigs["kelownachev"] = array(
    'password' => 'kelownachev',
    "email" => "regan@smedia.ca",
    'log' => true,
    // 'tag_debug' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "kelownachev",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more info!",
        'fb_lookalike_description' => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
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
            '#323232',
            '#323232',
),
        'button_color_hover' => array(
            '#CC9834',
            '#CC9834',
),
        'button_color_active' => array(
            '#CC9834',
            '#CC9834',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Special offer coupon from Kelowna Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Kelowna Chevrolet Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'leads@donfolk.motosnap.com',
),
        'special_to' => array(
            'leads@donfolk.motosnap.com',
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
					<contact>
						<name part="full">Kelowna Chevrolet</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia Coupon</name>
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
    'adf_to' => array(
        'leads@donfolk.motosnap.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
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
                        'Get Your Price!',
                        'Get Your Exclusive Price',
                        'E- Price',
                        'Special Pricing!',
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'Get  Current Market  Price',
                        'GET CURRENT MARKET PRICE',
                        'Get Internet Price Now',
                        'Get E-Price',
                        'GET E-PRICE',
                        'Get Price Updates',
                        'Price Updates',
                        'Track Price',
),
],
],
            'styles' => array(
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
                'Platinum' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
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
                'Black' => array(
                    'normal' => array(
                        'color' => '#ffffff',
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
        'financing' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4 a',
            'css-class' => '.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4 a',
            'css-hover' => '.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4 a:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4 a',
                    'values' => array(
                        'Payment Calculation',
                        'Estimate Payments',
                        'Payment Options',
                        'Special Finance Offers',
                        'Calculate Payments',
                        'Financing Options',
                        'Calculate Your Payments',
                        'Explore Payments',
),
],
],
            'styles' => array(
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
                'Black' => array(
                    'normal' => array(
                        'color' => '#ffffff',
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
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
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
                'Platinum' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
),
],
],
);