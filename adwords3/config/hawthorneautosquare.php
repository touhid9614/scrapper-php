<?php

global $CronConfigs;
$CronConfigs["hawthorneautosquare"] = array(
    "name" => " hawthorneautosquare",
    "email" => "regan@smedia.ca",
    "password" => " hawthorneautosquare",
    "log" => true,
    "banner" => array(
        "template" => "hawthorneautosquare",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    /*   "lead" => array(
                 'live' => true,
                 'lead_type_' => true,
                 'lead_type_new' => true,
                 'lead_type_used' => true,
                 'bg_color' => '#EFEFEF',
                 'text_color' => '#404450',
                 'border_color' => '#E5E5E5',
                 'button_color' => array(
                     '#0074AD',
                     '#0074AD',
                 ),
                 'button_color_hover' => array(
                     '#5F9434',
                     '#5F9434',
                 ),
                 'button_color_active' => array(
                     '#5F9434',
                     '#5F9434',
                 ),
                 'button_text_color' => '#FFFFFF',
                 'response_email_subject' => 'Customer Appreciation Raffle from Hawthorne Auto Square',
                 'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Hawthorne Auto Square Team',
                 'forward_to' => array(
                     'marshal@smedia.ca
         mohamed@hawthorneautosquare.com',
                 ),
                 'special_to' => array(
                     'hawthorne.obt20s@zapiermail.com',
                 ),
                 'special_email' => '<?xml version="1.0"?>
         		<?adf version="1.0"?>
         		<adf>
         			<prospect>
         				<id sequence="[total_count]" source="Hawthorne Auto Square"></id>
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
         						<name part="full">Hawthorne Auto Square</name>
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
                 'display_after' => 30000,
                 'retarget_after' => 5000,
                 'fb_retarget_after' => 5000,
                 'adword_retarget_after' => 5000,
                 'visit_count' => 0,
             ),*/
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/listings\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'strong a[href*="pre-approval"]',
            'css-class' => 'strong a[href*="pre-approval"]',
            'css-hover' => 'strong a[href*="pre-approval"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'strong a[href*="pre-approval"]',
                    'values' => array(
                        'Get Financed Today',
                        'Apply for Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Special Finance Offers!',
                        'Estimate Payments',
                        'Calculate Your Payments',
                        'Financing Options',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#396AB3,#396AB3)',
                        'border-color' => '396AB3',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5089,#2A5089)',
                        'border-color' => '2A5089',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => 'FF6633',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C34E27,#C34E27)',
                        'border-color' => 'C34E27',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6DAB3D,#6DAB3D)',
                        'border-color' => '6DAB3D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#52832D,#52832D)',
                        'border-color' => '52832D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/listings\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="contact-us"]:nth-of-type(2)',
            'css-class' => 'a[href*="contact-us"]:nth-of-type(2)',
            'css-hover' => 'a[href*="contact-us"]:nth-of-type(2):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*="contact-us"]:nth-of-type(2)',
                    'values' => array(
                        'Call Us Today',
                        'Reach Us',
                        'Click Here To Contact Us',
                        'Contact Us',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6DAB3D,#6DAB3D)',
                        'border-color' => '6DAB3D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#52832D,#52832D)',
                        'border-color' => '52832D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => 'FF6633',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C34E27,#C34E27)',
                        'border-color' => 'C34E27',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#396AB3,#396AB3)',
                        'border-color' => '396AB3',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5089,#2A5089)',
                        'border-color' => '2A5089',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/listings\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="contact-us"]:nth-of-type(3)',
            'css-class' => 'a[href*="contact-us"]:nth-of-type(3)',
            'css-hover' => 'a[href*="contact-us"]:nth-of-type(3):hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*="contact-us"]:nth-of-type(3)',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => 'FF6633',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C34E27,#C34E27)',
                        'border-color' => 'C34E27',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#396AB3,#396AB3)',
                        'border-color' => '396AB3',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2A5089,#2A5089)',
                        'border-color' => '2A5089',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6DAB3D,#6DAB3D)',
                        'border-color' => '6DAB3D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#52832D,#52832D)',
                        'border-color' => '52832D',
                        'color' => '#fff',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 2px 2px',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
],
],
);