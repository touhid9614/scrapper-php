<?php

global $CronConfigs;
$CronConfigs["rayskillmanhyundaiwest"] = array(
    "name" => " rayskillmanhyundaiwest",
    "email" => "regan@smedia.ca",
    "password" => " rayskillmanhyundaiwest",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "rayskillmanhyundaiwest",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
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
            '#1E71B8',
            '#1E71B8',
),
        'button_color_hover' => array(
            '#113E64',
            '#113E64',
),
        'button_color_active' => array(
            '#113E64',
            '#113E64',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 Off Purchase of New Vehicle',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ray Skillman Westside Hyundai Team',
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
				<id sequence="[total_count]" source="Ray Skillman Westside Hyundai"></id>
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
						<name part="full">Ray Skillman Westside Hyundai</name>
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
            'vdp' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
            'service' => '',
),
),
    'adf_to' => array(
        'leads@skillmanautomall.motosnap.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        //        'financing' => [
        //            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.pay-calc-link-vdp div',
        //            'css-class' => 'div.pay-calc-link-vdp div',
        //            'css-hover' => 'div.pay-calc-link-vdp div:hover',
        //            'button_action' => [
        //                'form',
        //                'finance',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'financing' => [
        //                    'target' => 'div.pay-calc-link-vdp div',
        //                    'values' => array(
        //                        'Calculate Your Payments',
        //                        'Estimate Payments',
        //                        'Payment Options',
        //                        'Explore Payments',
        //                        'Calculate Payments',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B02226,#B02226)',
        //                        'border-color' => '#e01212',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#961D20,#961D20)',
        //                        'border-color' => '#c60c0d',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#24B149,#24B149)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#1F973E,#1F973E)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#004B8D,#004B8D)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#003D73,#003D73)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'yellow' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F3BC00,#F3BC00)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#D9A800,#D9A800)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //            ),
        //        ],
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.button.cta-button',
            'css-class' => '.button.cta-button',
            'css-hover' => '.button.cta-button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.button.cta-button',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Price',
                        'Get Your Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#961E21,#961E21)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#76171A,#76171A)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006400,#006400)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#50A0D7,#50A0D7)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3876A0,#3876A0)',
                        'border-color' => '359D22',
),
),
),
],
        //        'trade-in' => [
        //            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.trade-link-vdp div',
        //            'css-class' => 'div.trade-link-vdp div',
        //            'css-hover' => 'div.trade-link-vdp div:hover',
        //            'button_action' => [
        //                'form',
        //                'trade-in',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'trade-in' => [
        //                    'target' => 'div.trade-link-vdp div',
        //                    'values' => array(
        //                        'What\'s Your Trade Worth?',
        //                        'Value Your Trade',
        //                        'We\'ll Buy Your Car',
        //                        'Trade-In Offer',
        //                        'We Want Your Car',
        //                        'Get Trade-In Value',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B02226,#B02226)',
        //                        'border-color' => '#e01212',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#961D20,#961D20)',
        //                        'border-color' => '#c60c0d',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#24B149,#24B149)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#1F973E,#1F973E)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#004B8D,#004B8D)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#003D73,#003D73)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'yellow' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F3BC00,#F3BC00)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#D9A800,#D9A800)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //            ),
        //        ],
        'request-information' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.voi-btn-vdp.voi-icon-bounce-vdp',
            'css-class' => '.voi-btn-vdp.voi-icon-bounce-vdp',
            'css-hover' => '.voi-btn-vdp.voi-icon-bounce-vdp:hover',
            'button_action' => [
                'form',
                'eprice',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '.voi-btn-vdp.voi-icon-bounce-vdp',
                    'values' => array(
                        'Get A Quote',
                        'Inquire Today',
                        'Lock This Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#961E21,#961E21)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#76171A,#76171A)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008B00,#008B00)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#006400,#006400)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#50A0D7,#50A0D7)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#3876A0,#3876A0)',
                        'border-color' => '359D22',
),
),
),
],
],
);