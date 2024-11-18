<?php

global $CronConfigs;

$CronConfigs["reginamotorproducts"] = array(
    'name' => 'reginamotorproducts',
    'email' => 'regan@smedia.ca',
    'password' => 'reginamotorproducts',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'max_cost' => 0,
    'cost_distribution' =>
    array(
        'adwords' => 0,
        'youtube' => 0,
    ),
    'create' =>
    array(),
    'new_descs' =>
    array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs' =>
    array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'customer_id' => '598-843-4331',
    'bing_account_id' => 149396885,
    'banner' =>
    array(
        'template' => 'reginamotorproducts',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today. Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' =>
        array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'font_color' => 'ffffff',
    ),
    'lead' =>
    array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' =>
        array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
        ),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' =>
        array(
            '#363791',
            '#363791',
        ),
        'button_color_hover' =>
        array(
            '#0E0E38',
            '#0E0E38',
        ),
        'button_color_active' =>
        array(
            '#0E0E38',
            '#0E0E38',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Save $200 on your new or used vehicle purchase!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Regina Motor Products Team',
        'forward_to' =>
        array(
            'marshal@smedia.ca',
        ),
        'special_to' =>
        array(
            'smedia@regina-motorproducts.net',
        ),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Regina Motor Products"></id>
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
						<name part="full">Regina Motor Products</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia</name>
					<url>https://smedia.ca</url>
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
        'lead_in' =>
        array(
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
        ),
        'custom_div' => '',
    ),
    'lead_to' =>
    array(
        'deanna.rmp@gmail.com',
        'cathychalupiak@reginamotorproducts.ca',
    ),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' =>
    array(
        'request-a-quote' =>
        array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' =>
            array(
                'default' => NULL,
            ),
            'action-target' => '[name="d28bc085-4cad-42b7-bdac-4ef44fa86198"]',
            'css-class' => '[name="d28bc085-4cad-42b7-bdac-4ef44fa86198"]',
            'css-hover' => '[name="d28bc085-4cad-42b7-bdac-4ef44fa86198"]:hover',
            'button_action' =>
            array(
                'form',
                'e-price',
            ),
            'sizes' =>
            array(
                100 =>
                array(),
            ),
            'texts' =>
            array(
                'request-a-quote' =>
                array(
                    'target' => '[name="d28bc085-4cad-42b7-bdac-4ef44fa86198"]',
                    'values' =>
                    array(
                        'Get Special Pricing',
                        'Special Pricing',
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Request a Quote',
                        'Get a Quote',
                    ),
                ),
            ),
            'styles' =>
            array(
                'orange' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#C79E36,#C79E36)',
                        'border-color' => 'C79E36',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#A7852D,#A7852D)',
                        'border-color' => 'A7852D',
                    ),
                ),
                'blue' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#363793,#363793)',
                        'border-color' => '363793',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#252675,#252675)',
                        'border-color' => '252675',
                    ),
                ),
                'green' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#00B389,#00B389)',
                        'border-color' => '00B389',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#038C6C,#038C6C)',
                        'border-color' => '038C6C',
                    ),
                ),
            ),
        ),
        'financing' =>
        array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' =>
            array(
                'default' => NULL,
            ),
            'action-target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' =>
            array(
                'form',
                'finance',
            ),
            'sizes' =>
            array(
                100 =>
                array(),
            ),
            'texts' =>
            array(
                'financing' =>
                array(
                    'target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' =>
                    array(
                        'Get Pre-Approved',
                        'Apply for Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Explore Payments',
                    ),
                ),
            ),
            'styles' =>
            array(
                'orange' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#C79E36,#C79E36)',
                        'border-color' => 'C79E36',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#A7852D,#A7852D)',
                        'border-color' => 'A7852D',
                    ),
                ),
                'blue' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#363793,#363793)',
                        'border-color' => '363793',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#252675,#252675)',
                        'border-color' => '252675',
                    ),
                ),
                'green' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#00B389,#00B389)',
                        'border-color' => '00B389',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#038C6C,#038C6C)',
                        'border-color' => '038C6C',
                    ),
                ),
            ),
        ),
    ),
);
