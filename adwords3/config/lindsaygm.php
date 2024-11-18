<?php

global $CronConfigs;
$CronConfigs["lindsaygm"] = array(
    'bid' => 3.0,
    'log' => true,
    'password' => 'lindsaygm',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bing_account_id' => 156003218,
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'max_cost' => 1250,
    'cost_distribution' => array(
        'new' => 535,
        'used' => 655,
        'youtube' => 60,
),
    'email' => 'regan@smedia.ca',
    'post_code' => 'K7S 1S6',
    'trackers' => array(
        'new_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
),
    'create' => array(
        "new_search" => yes,
        "used_search" => yes,
),
    'host_url' => 'http://www.lindsaygm.ca/',
    'display_url' => 'www.lindsaygm.ca',
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'options_descs' => array(
        0 => array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
        0 => array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'customer_id' => '675-512-6310',
    'banner' => array(
        'template' => 'lindsaygm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'hst' => true,
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => true,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
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
        'button_color' => array(
            0 => '#D40000',
            1 => '#D40000',
),
        'button_color_hover' => array(
            0 => '#000000',
            1 => '#000000',
),
        'button_color_active' => array(
            0 => '#000000',
            1 => '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Lindsay Buick GMC',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Lindsay Buick GMC Team',
        'forward_to' => array(
            0 => 'apurdue@lindsaygm.ca',
            1 => 'aveale@lindsaygm.ca',
            2 => 'marshal@smedia.ca',
            3 => 'c.hare@lindsaygm.ca',
),
        'special_to' => array(
            0 => 'lindsaybuickgmc.smedia@quickestreply.com',
            1 => 'adf_to@smedia.ca',
),
        'special_email' => '',
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
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
),
    'lead_to' => array(
        0 => 'apurdue@lindsaygm.ca',
        1 => 'laurav@lindsaygm.ca',
        2 => 'aveale@lindsaygm.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(
                    'font-size' => '1.4rem',
),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
                    'values' => array(
                        0 => 'Get Internet Price',
                        1 => 'Get Our Best Price',
                        2 => 'Get More Information',
                        3 => 'Get More Info',
                        4 => 'Best Price',
                        5 => 'Check Availability',
                        6 => 'Get Special Price!',
                        7 => 'SPECIAL PRICING!',
                        8 => 'Confirm Availability',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'DD820D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'C51616',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#099C09,#099C09)',
                        'border-color' => '63B428',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0052CB,#0052CB)',
                        'border-color' => '287AB4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'sizes' => array(
                100 => array(
                    'font-size' => '1.4rem',
),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[name=4969ed15-0c26-4ba1-8a8d-81cdc4ec014a]',
                    'values' => array(
                        0 => 'Virtual Tour',
                        1 => 'Take Virtual Tour',
                        2 => 'Take Virtual Tour!',
                        3 => 'Interested in Virtual Tour?',
                        4 => 'Online Tour',
                        5 => 'Take Online Tour',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'DD820D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF0000,#FF0000)',
                        'border-color' => 'C51616',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#099C09,#099C09)',
                        'border-color' => '63B428',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0052CB,#0052CB)',
                        'border-color' => '287AB4',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'name' => 'lindsaygm',
);