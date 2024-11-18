<?php

global $CronConfigs;
$CronConfigs["virdenmainline"] = array(
    'password' => 'virdenmainline',
    "email" => "regan@smedia.ca",
    'log' => true,
    //'budget'    => 2.0,
    'on15' => true,
    'post_code' => 'N7T 3W1',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
    ),
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'youtube' => 0,
    ),
    'adgroup_version' => 'v5',
    //tracker
    "create" => array(
        "special_search" => no,
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
    ),
    "host_url" => "http://www.virdenmainline.com",
    //must start with http or https and end without /
    "display_url" => "www.virdenmainline.com",
    //Max lenght 35 char
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "special_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
        ),
    ),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
        ),
    ),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
        ),
    ),
    "customer_id" => "385-699-1171",
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "virdenmainline",
        "fb_description" => "Are you still interested in the [Year] [Make] [Model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [Year] [Make] [Model]! Click for more information.",
        "fb_dynamiclead_description" => "Still interested in [Year] [Make] [Model]? Click below, fill in your info to get \$250 in-store credit, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            //"used_display"  => "quick_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            //"used_retargeting" => "quick_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
        ),
        "font_color" => "#ffffff",
    ),
    /*
    "lead" => array(
            'live' => false,
            'lead_type_' => false,
            'lead_type_new' => false,
            'lead_type_used' => false,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#333333',
                '#333333',
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
            'response_email_subject' => '$250 OFF coupon from Virden Mainline',
            'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Virden Mainline Team',
            'forward_to' => array(
                'marshal@smedia.ca',
            ),
            'special_to' => array(
                'virdenmai.smedia@quickestreply.com',
            ),
            'special_email' => '<?xml version="1.0"?>
    		<?adf version="1.0"?>
    		<adf>
    			<prospect>
    				<id sequence="[total_count]" source="Virden Mainline"></id>
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
    						<name part="full">Virden Mainline</name>
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
    */
//    'lead_to' => array(
//        'brad@virdenmainline.com',
//        'marisa@virdenmainline.com',
//    ),
//    'adf_to' => array(
//        'Virdenmai.smedia@quickestreply.com',
//    ),
//    //This is for ADF XML eamils to CRM, usually this email addresses start with leads@ webleads@ etc, check special_to eamils for clarification
//    'form_live' => false,
//    'buttons_live' => false,
//    'buttons' => [
//        'request-a-quote' => [
//            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
//            'target' => null,
//            //Don't move button
//            'locations' => [
//                'default' => null,
//            ],
//            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
//            'css-class' => 'a.button.cta-button.block.button-form.fancybox',
//            'css-hover' => 'a.button.cta-button.block.button-form.fancybox:hover',
//            'button_action' => [
//                'form',
//                'e-price',
//            ],
//            'sizes' => [
//                '100' => [],
//            ],
//            'texts' => [
//                'request-a-quote' => [
//                    'target' => 'a.button.cta-button.block.button-form.fancybox',
//                    'values' => array(
//                        'GET MORE INFO',
//                        'ASK A QUESTION',
//                        'GET E-PRICE',
//                        'GET INTERNET PRICE',
//                        'GET OUR BEST PRICE',
//                        'Check Availability',
//                        'Get Special Price!',
//                        'SPECIAL PRICING!',
//                        'Confirm Availability',
//                        'Get your price',
//                        'Your Price',
//                    ),
//                ],
//            ],
//            'styles' => array(
//                'orange' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EE8100,#EE8100)',
//                        'border-color' => '#ee8100',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#CF540E,#CF540E)',
//                        'border-color' => '#cf540e',
//                    ),
//                ),
//                'red' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#EE3000,#EE3000)',
//                        'border-color' => '#ee3000',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
//                        'border-color' => '#c60c0d',
//                    ),
//                ),
//                'green' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#00A84E,#00A84E)',
//                        'border-color' => '#00a84e',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#359D22,#359D22)',
//                        'border-color' => '#359d22',
//                    ),
//                ),
//                'blue' => array(
//                    'normal' => array(
//                        'background' => 'linear-gradient(#086597,#086597)',
//                        'border-color' => '#086597',
//                    ),
//                    'hover' => array(
//                        'background' => 'linear-gradient(#188BB7,#188BB7)',
//                        'border-color' => '#188bb7',
//                    ),
//                ),
//            ),
//        ],
//    ],
);