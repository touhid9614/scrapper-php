<?php

global $CronConfigs;
$CronConfigs["rousseltoyota"] = array(
    "name" => " rousseltoyota",
    "email" => "regan@smedia.ca",
    "password" => " rousseltoyota",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "rousseltoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#EB0A1E',
            '#EB0A1E',
),
        'button_color_hover' => array(
            '#AD2039',
            '#AD2039',
),
        'button_color_active' => array(
            '#AD2039',
            '#AD2039',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Roussel Toyota',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Roussel Toyota Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'bwebauto@roussel-toyota.net',
            'allison_macintosh@roussel.toyota.ca',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Roussel Toyota"></id>
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
						<name part="full">Roussel Toyota</name>
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
    'adf_to' => array(
        'bwebauto@roussel-toyota.net',
        'allison_macintosh@roussel.toyota.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=road-test-request].cta',
            'css-class' => 'a[href*=road-test-request].cta',
            'css-hover' => 'a[href*=road-test-request].cta:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=road-test-request].cta',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '188BB7',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => '188BB7',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=pre-approval].cta.prime.btn-odd',
            'css-class' => 'a[href*=pre-approval].cta.prime.btn-odd',
            'css-hover' => 'a[href*=pre-approval].cta.prime.btn-odd:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=pre-approval].cta.prime.btn-odd',
                    'values' => array(
                        'Financing Options',
                        'Get Financed Today',
                        'Get Your Loan Online',
                        'Apply for Financing',
                        'Get Approved',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '188BB7',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=exchange-vehicle-evaluation].cta.prime.btn-odd',
            'css-class' => 'a[href*=exchange-vehicle-evaluation].cta.prime.btn-odd',
            'css-hover' => 'a[href*=exchange-vehicle-evaluation].cta.prime.btn-odd:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=exchange-vehicle-evaluation].cta.prime.btn-odd',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                        'Trade Offer',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '188BB7',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#58595B,#58595B)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => '188BB7',
),
),
),
],
],
);