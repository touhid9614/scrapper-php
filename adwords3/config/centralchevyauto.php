<?php

global $CronConfigs;
$CronConfigs["centralchevyauto"] = array(
    "name" => " centralchevyauto",
    "email" => "regan@smedia.ca",
    "password" => " centralchevyauto",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "centralchevyauto",
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
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#3172E9',
            '#3172E9',
        ),
        'button_color_hover' => array(
            '#0A1B49',
            '#0A1B49',
        ),
        'button_color_active' => array(
            '#0A1B49',
            '#0A1B49',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 Credit towards Accessories at Central Chevrolet',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Central Chevrolet Team',
        'forward_to' => array(
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'centralchevyinc@newsales.leads.cmdlr.com',
        ),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Central Chevrolet"></id>
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
						<name part="full">Central Chevrolet</name>
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
        'centralchevyinc@newsales.leads.cmdlr.com',
    ),
    'lead_to' => array(
        'centralchevyinc@newsales.leads.cmdlr.com',
    ),
    'star_to' => array(
        'centralchevyinc@newsales.leads.cmdlr.com',
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.cta-caption a.button.cta-button.vdp-primary',
            'css-class' => '.cta-caption a.button.cta-button.vdp-primary',
            'css-hover' => '.cta-caption a.button.cta-button.vdp-primary:hover',
            //            'button_action' => [
            //                'form',
            //                'trade-in',
            //            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '.cta-caption a.button.cta-button.vdp-primary',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Get Trade-In Value',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B3282D,#B3282D)',
                        'border-color' => '#B3282D',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#73191C,#73191C)',
                        'border-color' => '#73191C',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008000,#008000)',
                        'border-color' => '#008000',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#004000,#004000)',
                        'border-color' => '#004000',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A1B49,#0A1B49)',
                        'border-color' => '#0A1B49',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#071333,#071333)',
                        'border-color' => '#071333',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D6AB4C,#D6AB4C)',
                        'border-color' => '#D6AB4C',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#967836,#967836)',
                        'border-color' => '#967836',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '.button.cta-button.vdp-primary.button-form.fancybox',
            'css-class' => '.button.cta-button.vdp-primary.button-form.fancybox',
            'css-hover' => '.button.cta-button.vdp-primary.button-form.fancybox:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.button.cta-button.vdp-primary.button-form.fancybox',
                    'values' => array(
                        'Get Price Updates',
                        'Get Best Price',
                        'Get Current Market Price',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Get Your Exclusive Price',
                        'Get Special Price',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B3282D,#B3282D)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#73191C,#73191C)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#008000,#008000)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#004000,#004000)',
                        'border-color' => '#359d22',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A1B49,#0A1B49)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#071333,#071333)',
                        'border-color' => '#359d22',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D6AB4C,#D6AB4C)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#967836,#967836)',
                        'border-color' => '#359d22',
                    ),
                ),
            ),
        ],
    ],
);