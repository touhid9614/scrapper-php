<?php

global $CronConfigs;
$CronConfigs["echovalleygm"] = array(
    'name'              => 'echovalleygm',
    'email'             => 'regan@smedia.ca',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'password'          => 'echovalleygm',
    'log'               => true,
    'max_cost'          => 813.8,
    'cost_distribution' => array(
        'adwords' => 813.8,
    ),
    'create'            => array(
        'new_search'  => true,
        'used_search' => true,
    ),
    'new_descs'         => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'customer_id'       => '939-726-0009',
    'banner'            => array(
        'template'                 => 'echovalleygm',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',

        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',

        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
        'old_price_new'            => 'msrp',
        'styels'                   => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
    ),
    'lead'              => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'lead_type_service'      => false,
        'shown_cap'              => false,
        'fillup_cap'             => false,
        'session_close'          => false,
        'device_type'            => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'sent_client_email'      => true,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#CD363A',
            '#CD363A',
        ),
        'button_color_hover'     => array(
            '#2B3338',
            '#2B3338',
        ),
        'button_color_active'    => array(
            '#2B3338',
            '#2B3338',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Echo Valley Motor Products',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Echo Valley Motor Products Team',
        'forward_to'             => array(
            'jaysonk@echovalleygm.com',
            'murraykurtz@yahoo.ca',
            'leads@echovalleygm.com',
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'echovalle.dealerdirect@quickestreply.com',
            'adf_to@smedia.ca',
        ),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'video_smart_offer'      => false,
        'video_smart_offer_form' => false,
        'video_url'              => '',
        'video_title'            => '',
        'video_description'      => '',
        'lead_in'                => array(
            'vdp'           => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}/',
            'service_regex' => '',
        ),
    ),
    'lead_to'           => array(
        'echovalleygm@sasktel.net',
        'murraykurtz@yahoo.ca',
        'leads@echovalleygm.com',
        'wecare@echovalleygm.com',
    ),
    'form_live'         => true,
    'buttons_live'      => true,
    'buttons'           => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class'     => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover'     => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                    ),
                ),
            ),
            'styles'        => array(
                'blue'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#18549E,#18549E)',
                        'border-color' => '18549E',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
                    ),
                ),
                'red'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
                    ),
                ),
                'green'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
                    ),
                ),
            ),
        ),
        'test-drive'      => array(
            'url-match'     => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'test-drive' => array(
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Schedule My Visit',
                        'Test Drive',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
                    ),
                ),
            ),
            'styles'        => array(
                'blue'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#18549E,#18549E)',
                        'border-color' => '18549E',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
                    ),
                ),
                'red'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
                    ),
                ),
                'green'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
                    ),
                ),
            ),
        ),
    ),
);