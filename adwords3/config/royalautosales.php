<?php

global $CronConfigs;
$CronConfigs["royalautosales"] = array(
    "name" => " royalautosales",
    "email" => "regan@smedia.ca",
    "password" => " royalautosales",
    "log" => true,
    "banner" => array(
        "template" => "royalautosales",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#D38C3E',
            '#D38C3E',
        ),
        'button_color_hover' => array(
            '#010101',
            '#010101',
        ),
        'button_color_active' => array(
            '#010101',
            '#010101',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 Gas Card offer from Royal Auto Sales',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Royal Auto Sales Team',
        'forward_to' => array(
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'webleads@royalautosales.dsmessage.com',
        ),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Royal Auto Sales"></id>
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
						<name part="full">Royal Auto Sales</name>
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
  /*  'adf_to' => array(
        'webleads@royalautosales.dsmessage.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/ii',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.btn-group  button.btn.btn-default.hash-st_request_a_quote.custom-btn.popup-overlay',
            'css-class' => 'div.btn-group  button.btn.btn-default.hash-st_request_a_quote.custom-btn.popup-overlay',
            'css-hover' => 'div.btn-group  button.btn.btn-default.hash-st_request_a_quote.custom-btn.popup-overlay:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.btn-group  button.btn.btn-default.hash-st_request_a_quote.custom-btn.popup-overlay',
                    'values' => array(
                        'Get More Details',
                        'More Info',
                        'Request More Info',
                        'Ask a Question!',
                        'Check Availability!',
                        'Ask an Expert',
                        'Learn More',
                        'Get More Info',
                    ),
                ],
            ],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B68F3B,#B68F3B)',
                        'border-color' => '#B68F3B ',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'royal-purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C267E,#4C267E)',
                        'border-color' => '#4C267E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '#4169E1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '#424242',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/ii',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.btn-group button.btn.btn-default.open-tab.custom-btn.popup-overlay',
            'css-class' => 'div.btn-group button.btn.btn-default.open-tab.custom-btn.popup-overlay',
            'css-hover' => 'div.btn-group button.btn.btn-default.open-tab.custom-btn.popup-overlay:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'div.btn-group button.btn.btn-default.open-tab.custom-btn.popup-overlay',
                    'values' => array(
                        'Get Approved',
                        'Get Financed Today',
                        'Apply For Financing',
                        'Get Your Loan Online',
                    ),
                ],
            ],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B68F3B,#B68F3B)',
                        'border-color' => '#B68F3B ',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'royal-purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C267E,#4C267E)',
                        'border-color' => '#4C267E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '#4169E1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '#424242',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                    ),
                ),
            ),
        ],
        'financing_custom' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/ii',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#getApproved',
            'css-class' => '#getApproved',
            'css-hover' => '#getApproved:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '#getApproved',
                    'values' => array(
                        'Get Approved',
                        'Get Financed Today',
                        'Apply For Financing',
                        'Get Your Loan Online',
                    ),
                ],
            ],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B68F3B,#B68F3B)',
                        'border-color' => '#B68F3B ',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C267E,#4C267E)',
                        'border-color' => '#4C267E',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '#4169E1',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '#424242',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/ii',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#scheduleTestDrive',
            'css-class' => '#scheduleTestDrive',
            'css-hover' => '#scheduleTestDrive:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '#scheduleTestDrive',
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
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B68F3B,#B68F3B)',
                        'border-color' => '#B68F3B ',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C267E,#4C267E)',
                        'border-color' => '#4C267E',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '#4169E1',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '#424242',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/ii',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#tradeIn',
            'css-class' => '#tradeIn',
            'css-hover' => '#tradeIn:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '#tradeIn',
                    'values' => array(
                        'What is Your Vehicle Worth?',
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'Get Trade-In Value',
                        'Appraise Your Trade',
                    ),
                ],
            ],
            'styles' => array(
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B68F3B,#B68F3B)',
                        'border-color' => '#B68F3B ',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4C267E,#4C267E)',
                        'border-color' => '#4C267E',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '#4169E1',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '#424242',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'margin' => '10px',
                        'padding' => '12px',
                        'line-height' => '35px',
                    ),
                ),
            ),
        ],
    ],*/
);