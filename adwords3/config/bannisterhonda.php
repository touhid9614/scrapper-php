<?php

global $CronConfigs;
$CronConfigs["bannisterhonda"] = array(
    'password' => 'bannisterhonda',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "customer_id" => "426-078-4225",
    'max_cost' => 0,
    'bing_account_id' => 156002883,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_placement" => yes,
        "used_placement" => yes,
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
    //=====smart offer=====
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#C31B2C',
            '#C31B2C',
        ),
        'button_color_hover' => array(
            '#2ECE32',
            '#2ECE32',
        ),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Bannister Honda',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bannister Honda Team',
        'forward_to' => array(
            'tracye@bannisterhonda.com',
            'pat@bannisterhonda.com',
            'marshal@smedia.ca',
            'emilyg@bannisterhonda.com',
        ),
        'special_to' => array(
            'tracye@bannisterhonda.com',
            '1342bannsalesleads0101@dealermineinc.com',
        ),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Bannister Honda"></id>
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
							<name part="full">Bannister Honda</name>
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
    ),
    //===dynamic social ads===
    "banner" => array(
        "template" => "bannisterhonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click to get your best deal!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
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
 /*   'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[onclick*=trade-in]',
            'css-class' => '[onclick*=trade-in]',
            'css-hover' => '[onclick*=trade-in]:hover',
            //  'button_action' => ['form', 'trade-in'],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '[onclick*=trade-in]',
                    'values' => array(
                        'Value your trade',
                        'We want your car',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
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
        'Used trade-in' => [
            'url-match' => '/\\/(?:certified|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[onclick*=trade-in]',
            'css-class' => '[onclick*=trade-in]',
            'css-hover' => '[onclick*=trade-in]:hover',
            //  'button_action' => ['form', 'trade-in'],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '[onclick*=trade-in]',
                    'values' => array(
                        'Value your trade',
                        'We want your car',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
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
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#apply-for-finance',
            'css-class' => '#apply-for-finance',
            'css-hover' => '#apply-for-finance:hover',
            //            'button_action' => [
            //                'form',
            //                'finance',
            //            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '#apply-for-finance',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Explore Payments',
                        'Special Finance Offers!',
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
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[onclick*=BookATestDrive]',
            'css-class' => '[onclick*=BookATestDrive]',
            'css-hover' => '[onclick*=BookATestDrive]:hover',
            //            'button_action' => [
            //                'form',
            //                'test-drive',
            //            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '[onclick*=BookATestDrive]',
                    'values' => array(
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today',
                        'Book My Test Drive',
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
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div button[onclick*=bookatestdrive]',
            'css-class' => 'div button[onclick*=bookatestdrive]',
            'css-hover' => 'div button[onclick*=bookatestdrive]:hover',
            //            'button_action' => [
            //                'form',
            //                'test-drive',
            //            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div button[onclick*=bookatestdrive]',
                    'values' => array(
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today',
                        'Book My Test Drive',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'font-size' => '9px',
                        'height' => '40px',
                        'margin-top' => '0px',
                        'min-width' => '113px',
                        'width' => '100%'
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'font-size' => '9px',
                         'height' => '40px',
                        'margin-top' => '0px',
                        'min-width' => '113px',
                        'width' => '100%'
                    ),
                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#E01212,#E01212)',
//                        'border-color' => 'E01212',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
//                        'border-color' => 'C60C0D',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#54B740,#54B740)',
//                        'border-color' => '54B740',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#359D22,#359D22)',
//                        'border-color' => '359D22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
//                        'border-color' => '1CA0D1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#188BB7,#188BB7)',
//                        'border-color' => '188BB7',
//                    ),
//                ),
//                'Platinum' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#B9B099,#B9B099)',
//                        'border-color' => '1CA0D1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#ABA085,#ABA085)',
//                        'border-color' => '188BB7',
//                    ),
//                ),
//                'Black' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#333333,#333333)',
//                        'border-color' => '1CA0D1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#000000,#000000)',
//                        'border-color' => '188BB7',
//                    ),
//                ),
//                'Cyan' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
//                        'border-color' => '1CA0D1',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#0093CF,#0093CF)',
//                        'border-color' => '188BB7',
//                    ),
//                ),
            ),
        ],
    ],*/
);
