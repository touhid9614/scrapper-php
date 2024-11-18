<?php

global $CronConfigs;
$CronConfigs["barneswheatongmsouthsurrey"] = array(
    'password' => 'barneswheatongmsouthsurrey',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    /* === smart offer start === /
        "lead" => array(
            'live' => false,
            'lead_type_' => false,
            'lead_type_new' => false,
            'lead_type_used' => false,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#0E55A5',
                '#0E55A5',
            ),
            'button_color_hover' => array(
                '#1A3767',
                '#1A3767',
            ),
            'button_color_active' => array(
                '#1A3972',
                '#1A3972',
            ),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => '$1,000 Cashback from Barnes Wheaton GM South Surrey',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Barnes Wheaton GM South Surrey Team',
            'forward_to' => array(
                'websiteleads@barneswheatongm.com',
                'marshal@smedia.ca',
            ),
            'special_to' => array('leads@barneswheatonsouthleads.com',),
            'special_email' => '<?xml version="1.0"?>
    			<?adf version="1.0"?>
    			<adf>
    				<prospect>
    					<id sequence="[total_count]" source="Barnes Wheaton GM South Surrey"></id>
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
    							<name part="full">Barnes Wheaton GM South Surrey</name>
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
        ),  / === smart offer end === */
    /* ===dynamic social ads=== */
    "banner" => array(
        "template" => "barneswheatongmsouthsurrey",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Check out our best price, we'll beat any price in B.C.! Click for more info.",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
  /*  'adf_to' => array(
        'websiteleads@barneswheatongm.com',
    ),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
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
                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
                    'values' => array(
                        'GET E-PRICE',
                        'GET INTERNET PRICE',
                        'GET OUR BEST PRICE',
                        'GET SPECIAL PRICE',
                        'CURRENT MARKET PRICE',
                        'TODAY\'S MARKET PRICE',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                    ),
                ],
            ],
            'styles' => array(
                      'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F08900,#F08900)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E6001C,#E6001C)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#21A000,#21A000)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#359d22',
                    ),
                ),
          
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=ScheduleTestDrive].primary',
            'css-class' => 'a[href*=ScheduleTestDrive].primary',
            'css-hover' => 'a[href*=ScheduleTestDrive].primary:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=ScheduleTestDrive].primary',
                    'values' => array(
                        'TEST DRIVE TODAY',
                        'TEST DRIVE NOW',
                        'WANT TO TEST DRIVE',
                        'Book My Test Drive',
                        'SCHEDULE MY TEST DRIVE',
                    ),
                ],
            ],
            'styles' => array(
                        'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E6001C,#E6001C)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F08900,#F08900)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#cf540e',
                    ),
                ),
        
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#21A000,#21A000)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],*/
);