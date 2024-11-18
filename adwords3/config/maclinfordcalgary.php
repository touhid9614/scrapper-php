<?php

global $CronConfigs;
$CronConfigs["maclinfordcalgary"] = array(
    'password' => 'maclinfordcalgary',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    //'tag_debug' => false,
    'max_cost' => 150,
    'customer_id' => '893-810-9162',
    "create" => array(
        'new_search' => true,
        'used_search' => true,
        'new_placement' => true,
        'used_placement' => true,
        'new_display' => true,
        'used_display' => true,
        'new_retargeting' => true,
        'used_retargeting' => true,
        'new_marketbuyers' => false,
        'used_marketbuyers' => false,
        'new_combined' => true,
        'used_combined' => true,
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
    "banner" => array(
        "template" => "maclinfordcalgary",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click below for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
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
            '#3396CD',
            '#3396CD',
),
        'button_color_hover' => array(
            '#1F82B9',
            '#1F82B9',
),
        'button_color_active' => array(
            '#1F82B9',
            '#1F82B9',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 off coupon from Maclin Ford',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Maclin Ford Team',
        'forward_to' => array(
            'iteam@maclinford.com',
            'tamissy13@gmail.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@maclinford.motosnap.com',
            'tamissy13@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia_$500_off_coupon"></id>
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
					<vendorname>Maclin Ford</vendorname>
					<contact>
						<name part="full">Maclin Ford</name>
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
),
    'adf_to' => array(
        'leads@maclinford.motosnap.com',
),
    'lead_to' => array(
        'iteam@maclinford.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.button-group a[data-target*=vdp_button_widget-13-modal]',
            'css-class' => '.button-group a[data-target*=vdp_button_widget-13-modal]',
            'css-hover' => '.button-group a[data-target*=vdp_button_widget-13-modal]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.button-group a[data-target*=vdp_button_widget-13-modal]',
                    'values' => array(
                        'Request More Info',
                        'Secure Price',
                        'Learn More',
                        'Reserve This Vehicle',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF8E06,#FF8E06)',
                        'border-color' => 'FF8E06',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD060D,#FD060D)',
                        'border-color' => 'FD060D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2CB450,#2CB450)',
                        'border-color' => '2CB450',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4161AB,#4161AB)',
                        'border-color' => '3296CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        //         'trade-in' => [
        //             'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
        //             'target' => null,
        //             //Don't move button
        //             'locations' => [
        //                 'default' => null,
        // ],
        //             'action-target' => '#vdp_button_widget-5 a[href *=trade-in-form].button',
        //             'css-class' => '#vdp_button_widget-5 a[href *=trade-in-form].button',
        //             'css-hover' => '#vdp_button_widget-5 a[href *=trade-in-form].button:hover',
        //             'button_action' => [
        //                 'form',
        //                 'trade-in',
        // ],
        //             'sizes' => [
        //                 '100' => [],
        // ],
        //             'texts' => [
        //                 'trade-in' => [
        //                     'target' => '#vdp_button_widget-5 a[href *=trade-in-form].button',
        //                     'values' => array(
        //                         'What\'s Your Trade Worth?',
        //                         'Value Your Trade',
        //                         'We\'ll Buy Your Car',
        //                         'Trade-In Offer',
        //                         'Trade-In Your Ride',
        //                         'Trade Offer',
        //                         'Trade Appraisal',
        // ),
        // ],
        // ],
        //             'styles' => array(
        //                 'orange' => array(
        //                     'normal' => array(
        //                         'background' => 'linear-gradient(#FF8E06,#FF8E06)',
        //                         'border-color' => 'FF8E06',
        //                         'color' => '#fff',
        // ),
        //                     'hover' => array(
        //                         'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                         'border-color' => 'CF540E',
        //                         'color' => '#fff',
        // ),
        // ),
        //                 'red' => array(
        //                     'normal' => array(
        //                         'background' => 'linear-gradient(#FD060D,#FD060D)',
        //                         'border-color' => 'FD060D',
        //                         'color' => '#fff',
        // ),
        //                     'hover' => array(
        //                         'background' => 'linear-gradient(#C60C0D,#C60C0D)',
        //                         'border-color' => 'C60C0D',
        //                         'color' => '#fff',
        // ),
        // ),
        //                 'green' => array(
        //                     'normal' => array(
        //                         'background' => 'linear-gradient(#2CB450,#2CB450)',
        //                         'border-color' => '2CB450',
        //                         'color' => '#fff',
        // ),
        //                     'hover' => array(
        //                         'background' => 'linear-gradient(#359D22,#359D22)',
        //                         'border-color' => '359D22',
        //                         'color' => '#fff',
        // ),
        // ),
        //                 'blue' => array(
        //                     'normal' => array(
        //                         'background' => 'linear-gradient(#4161AB,#4161AB)',
        //                         'border-color' => '3296CD',
        //                         'color' => '#fff',
        // ),
        //                     'hover' => array(
        //                         'background' => 'linear-gradient(#188BB7,#188BB7)',
        //                         'border-color' => '188BB7',
        //                         'color' => '#fff',
        // ),
        // ),
        // ),
        // ],
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target*=vdp_button_widget-7-modal]',
            'css-class' => 'a[data-target*=vdp_button_widget-7-modal]',
            'css-hover' => 'a[data-target*=vdp_button_widget-7-modal]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-target*=vdp_button_widget-7-modal]',
                    'values' => array(
                        'Test Drive at Work!',
                        'Book a Test Drive',
                        'Test Drive at Home!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF8E06,#FF8E06)',
                        'border-color' => 'FF8E06',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD060D,#FD060D)',
                        'border-color' => 'FD060D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2CB450,#2CB450)',
                        'border-color' => '2CB450',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4161AB,#4161AB)',
                        'border-color' => '3296CD',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
],
    'cost_distribution' => array(
        'new' => 75,
        'used' => 75,
),
);