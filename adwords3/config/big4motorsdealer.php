<?php

global $CronConfigs;
$CronConfigs["big4motorsdealer"] = array(
    "name" => "big4motorsdealer",
    "email" => "regan@smedia.ca",
    "password" => " big4motorsdealer",
    'log' => true,
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#AA0025',
            '#AA0025',
        ),
        'button_color_hover' => array(
            '#000000',
            '#000000',
        ),
        'button_color_active' => array(
            '#000000',
            '#000000',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$500 Visa Gift Card from Tire Chalet',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Big 4 Motors Team',
        'forward_to' => array(
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'pgauthier@big4motors.com',
            'rwalsh@big4motors.com',
            'ekeller@big4motors.com',
            'dschinnour@big4motors.com',
        ),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Big 4 Motors"></id>
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
							<name part="full">Big 4 Motors</name>
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
        'pgauthier@big4motors.com',
        'rwalsh@big4motors.com',
        'ekeller@big4motors.com',
        'dschinnour@big4motors.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        'Request More Info',
                        'Get More Information',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47300,#D47300)',
                        'border-color' => '#D47300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA6500,#BA6500)',
                        'border-color' => '#BA6500',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002D,#C3002D)',
                        'border-color' => '#C3002D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A90027,#A90027)',
                        'border-color' => '#A90027',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3CA000,#3CA000)',
                        'border-color' => '#3CA000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#075A87,#075A87)',
                        'border-color' => '#075A87',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#06496D,#06496D)',
                        'border-color' => '#06496D',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*=testdrive].btn',
            'css-class' => 'a[href*=testdrive].btn',
            'css-hover' => 'a[href*=testdrive].btn:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=testdrive].btn',
                    'values' => array(
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47300,#D47300)',
                        'border-color' => '#D47300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA6500,#BA6500)',
                        'border-color' => '#BA6500',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002D,#C3002D)',
                        'border-color' => '#C3002D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A90027,#A90027)',
                        'border-color' => '#A90027',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3CA000,#3CA000)',
                        'border-color' => '#3CA000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#075A87,#075A87)',
                        'border-color' => '#075A87',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#06496D,#06496D)',
                        'border-color' => '#06496D',
                    ),
                ),
            ),
        ],
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn',
            'css-class' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn',
            'css-hover' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'a.btn.btn-default.mycars-btn.mycars-add-alert-btn',
                    'values' => array(
                        'Watch Price',
                        'Watch This Price',
                        'Follow This Price',
                        'Track Price',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47300,#D47300)',
                        'border-color' => '#D47300',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA6500,#BA6500)',
                        'border-color' => '#BA6500',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002D,#C3002D)',
                        'border-color' => '#C3002D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A90027,#A90027)',
                        'border-color' => '#A90027',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3CA000,#3CA000)',
                        'border-color' => '#3CA000',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#075A87,#075A87)',
                        'border-color' => '#075A87',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#06496D,#06496D)',
                        'border-color' => '#06496D',
                    ),
                ),
            ),
        ],
    ],
);