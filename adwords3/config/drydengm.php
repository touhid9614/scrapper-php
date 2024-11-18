<?php

global $CronConfigs;
$CronConfigs["drydengm"] = array(
    'password' => 'drydengm',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'log' => true,
    'host_url' => 'http://www.drydengm.ca',
    'max_cost' => 250,
    'cost_distribution' => array(
        'all campaigns' => null,
),
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
            '#004EA1',
            '#004EA1',
),
        'button_color_hover' => array(
            '#004183',
            '#004183',
),
        'button_color_active' => array(
            '#004183',
            '#004183',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 offer from Dryden GM',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dryden GM Team',
        'forward_to' => array(
            'info@drydengm.ca',
            'doug@drydengm.ca',
            'marshal@smedia.ca',
            'internetsales@drydengm.ca',
            'joanne@drydengm.ca',
            'dustin@drydengm.ca',
),
        'special_to' => [],
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
            'vdp' => '/\\/(?:new|used)-inventory\\//',
            'service_regex' => '',
),
),
    'create' => [],
    'post_code' => 'P8N 2P6',
    'new_descs' => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[model] starting at [price]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[color] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model].',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[model] starting at [price]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => '[make] [model] starting',
            'desc2' => ' at [price]. Only [kilometers]km ',
),
),
    'options_descs' => array(
        array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'bing_account_id' => 156003017,
    'customer_id' => '503-930-9378',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'drydengm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'fb_retargeting_description_equinox' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_retargeting_description_terrain' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_lookalike_description_equinox' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_lookalike_description_terrain' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to get $200 accessory credit with purchase, and a product specialist will be in touch to aid in any questions.',
        'flash_style' => 'default',
        'hst' => true,
        'border_color' => '#dfdfdf',
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
    'lead_to' => array(
        'info@drydengm.ca',
        'trevor@drydengm.ca',
        'doug@drydengm.ca',
        'aileads@smedia.ca',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => array(
        'Used request-a-quote' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
            'css-class' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
            'css-hover' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
                    'values' => array(
                        'Get Our Best Price',
                        'Get Special Price Today',
                        'Get Special Price',
                        'Get Current Market Price',
                        'GET E-PRICE',
                        'SPECIAL PRICING!',
                        'Calculate your payments!',
                        'Test Drive at Home',
                        'Inquire Now',
                        'Inquire Online',
                        'Request Information',
                        'Special pricing!',
                        'You are Eligible for Special Pricing',
                        'Your exclusive price!',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'request-a-quote' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
            'css-class' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
            'css-hover' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
                    'values' => array(
                        'Get Our Best Price',
                        'Get Special Price Today',
                        'Get Special Price',
                        'Get Current Market Price',
                        'GET E-PRICE',
                        'SPECIAL PRICING!',
                        'Calculate your payments!',
                        'Test Drive at Home',
                        'Inquire Now',
                        'Inquire Online',
                        'Request Information',
                        'Special pricing!',
                        'You are Eligible for Special Pricing',
                        'Your exclusive price!',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '#188bb7',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=trade]',
            'css-class' => 'a[href*=trade]',
            'css-hover' => 'a[href*=trade]:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'a[href*=trade]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Value Your Trade Now',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'What\'s Your Car Worth?',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used test-drive' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*="road-test-used"]',
            'css-class' => 'a[href*="road-test-used"]',
            'css-hover' => 'a[href*="road-test-used"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*="road-test-used"]',
                    'values' => array(
                        'Test Drive Now',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=book-a-test-drive]',
            'css-class' => 'a[href*=book-a-test-drive]',
            'css-hover' => 'a[href*=book-a-test-drive]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*=book-a-test-drive]',
                    'values' => array(
                        'Test Drive Now',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '#188bb7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=financing-request]',
            'css-class' => 'a[href*=financing-request]',
            'css-hover' => 'a[href*=financing-request]:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a[href*=financing-request]',
                    'values' => array(
                        'No Hassle Financing',
                        'Special Finance Offers',
                        'Apply For Financing',
                        'Explore Payments',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'name' => 'drydengm',
    'smart_memo' => array(
        'live' => false,
        'live_new' => false,
        'live_used' => false,
        'live_home' => false,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => false,
        'video_url' => 'https://www.youtube.com/watch?v=wCFi9s3LhBU&ab_channel=sMediaProofs',
        'button_text' => 'BUILD AND PRICE',
        'url' => 'https://www.drydengm.ca/en/shop-online',
        'home_url' => 'https://www.drydengm.ca/en',
        'service_regex' => '',
        'bg_color' => '#ADADAD',
        'text_color' => '#404450',
        'border_color' => '#969696',
        'button_text_color' => '#DEDEDE',
        'button_color' => array(
            '#FF0000',
            '#FF0000',
),
        'button_color_hover' => array(
            '#D92929',
            '#D92929',
),
        'button_color_active' => array(
            '#D92929',
            '#D92929',
),
),
);