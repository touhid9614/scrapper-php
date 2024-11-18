<?php

global $CronConfigs;
$CronConfigs["tri_stateford"] = array(
    "name" => " tri_stateford",
    "email" => "regan@smedia.ca",
    "password" => " tri_stateford",
    "log" => true,
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
            '#3495CC',
            '#3495CC',
),
        'button_color_hover' => array(
            '#1D5371',
            '#1D5371',
),
        'button_color_active' => array(
            '#1D5371',
            '#1D5371',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Tri-State Ford',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Tri-State Ford Team',
        'forward_to' => array(
            'john.justice@tri-stateford.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@tristateford.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Tri-State Ford"></id>
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
						<name part="full">Tri-State Ford</name>
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
            'vdp' => '/\\/(?:new|used|certified)\\/+[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'adf_to' => '',
    'form_live' => false,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
          'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'button[href*=eprice-form]',
            'css-class' => 'button[href*=eprice-form]',
            'css-hover' => 'button[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button[href*=eprice-form]',
                    'values' => array(
                        'Request A Quote',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Get A Quote',
                        'Get Today’s Price',
                        'Get My Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
),
),
),
],
        'check-availibility' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'check-availibility' => [
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                       'Confirm Availability',
                        'Check Availability',
                        'Ask For Availability',
                        'Is This Available?',

),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
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
            'action-target' => 'a[href*=finance-application2].btn',
            'css-class' => 'a[href*=finance-application2].btn',
            'css-hover' => 'a[href*=finance-application2].btn:hover',
                       'button_action' => [
                           'form',
                           'finance',
                       ],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=finance-application2].btn',
                    'values' => array(

                        'Get Financed Today',
                        'Apply For Financing',
                        'Financing Options',
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Special Finance Offer',
                        'Get Approved',

),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#134985,#134985)',
                        'border-color' => '134985',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#103B6B,#103B6B)',
                        'border-color' => '103B6B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B01A25,#B01A25)',
                        'border-color' => 'B01A25',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C39A38,#C39A38)',
                        'border-color' => 'C39A38',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A17F2C,#A17F2C)',
                        'border-color' => 'A17F2C',
),
),
),
],


],
);