<?php

global $CronConfigs;
$CronConfigs["titanauto"] = array(
    'name' => 'Titan Auto',
    'log' => true,
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'titanauto',
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 4400.0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 4400,
),
    'bing_account_id' => 54095121,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'smart_banner' => array(
        'live' => true,
        'title' => 'Are you still interested in the',
),
    "email" => "marshal@smedia.ca",
    //tracker
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => true,
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
        'text_color' => '#225015',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#BD0000',
            '#800000',
),
        'button_color_hover' => array(
            '#B00000',
            '#700000',
),
        'button_color_active' => array(
            '#700000',
            '#B00000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Your offer from [dealership]',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Titan Auto Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'cars@titanauto.ca',
            'masterkeyy@gmail.com',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 20000,
        'retarget_after' => 10000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
            'service' => '/service/i',
),
),
    "create" => array(
        "new_search" => no,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_combined" => yes,
        "new_color" => no,
        "used_color" => yes,
),
    "post_code" => "S4R 8G3",
    "color_ad_url" => "http://www.titanauto.ca/all-inventory/index.htm?search=[color]&year=year[]&normalExteriorColor=[Color]&model=[model]",
    "host_url" => "http://titanauto.autotrader.ca",
    //must start with http or https and end without /
    "display_url" => "http://titanauto.autotrader.ca",
    //Max lenght 35 char
    "new_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
),
),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "starting at *[biweekly] b/w",
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
    "customer_id" => "888-503-2132",
    "banner" => array(
        'snapchat_image_index' => 0,
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        //'fb_marketplace_description' => '[description]',
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information to get your chance for a trip to Fabulous Las Vegas!! Our product specialist will be in touch to answer any questions.",
        "template" => "titanauto",
        "flash_style" => "default",
        "border_color" => "#000",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_combined" => "dynamic_banner",
            "used_combined" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
    'biweekly' => array(
        '2015' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 96,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 96,
),
),
        '2014' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 96,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 96,
),
),
        '2013' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 84,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 84,
),
),
        '2012' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 84,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 84,
),
),
        '2011' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 72,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 72,
),
),
        '2010' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
),
        '2009' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
),
        '2008' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 60,
),
),
        '2007' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 48,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 48,
),
),
        '2006' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 36,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'interest' => 0.0499,
                //5%
                'months' => 36,
),
),
        '2005' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 24,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'interest' => 0.0499,
                //5%
                'months' => 24,
),
),
        '2004' => array(
            'new' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'deposit' => 0,
                //inital deposit
                'interest' => 0.0499,
                //5%
                'months' => 12,
),
            'used' => array(
                'tax' => 0.1,
                //8% tax,
                'fee' => 0,
                //inital fee
                'interest' => 0.0499,
                //5%
                'months' => 12,
),
),
),
    'lead_to' => array(
        'cars@titanauto.ca',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.maincta-row.ctabox-row a',
            'css-class' => '.maincta-row.ctabox-row a',
            'css-hover' => '.maincta-row.ctabox-row a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.maincta-row.ctabox-row a',
                    'values' => array(
                        'Special Pricing!',
                        'Get Market Price',
                        'Market Pricing',
                        'Get E Price Now!',
                        'Internet Price',
                        'E- Price',
                        'Confirm Availability',
                        'Exclusive Price',
                        'Calculate Payments',
                        'Get Your Exclusive Price',
                        'GET SPECIAL PRICE!',
                        'SPECIAL PRICE!',
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
),
],
],
    'adf_to' => array(
        'leads@titanmail.ca',
),
    'fb_messenger' => false,
    'fb_page_id' => '143923312335088',
    'ab_tests' => [
        'trade' => [
            'trade-smart' => [
                'landing' => [
                    'selector' => 'div#gform_wrapper_13',
                    'pattern' => 'value-your-trade',
                    'insert_method' => 'html',
                    'fullview' => true,
],
                'srp' => [
                    'selector' => 'table#results-page:first',
                    'pattern' => '^(?:[^-]*-vehicles|pre-owned-vehicles|used-cars|used-vehicles|used-inventory|used-[^-]*-only|priced-under-\\d\\d?k)\\/?',
                    'insert_method' => 'before',
                    'fullview' => false,
],
                'vdp' => [
                    'selector' => 'div.vdp-shopping-tools',
                    'pattern' => '^inventory\\/',
                    'insert_method' => 'before',
                    'fullview' => false,
],
                'other' => [
                    'selector' => 'div#videobanner:first',
                    'pattern' => '.*',
                    'insert_method' => 'after',
                    'fullview' => false,
],
],
],
],
    'vinnauto' => array(
        'button_status' => true,
        'button_debug' => false,
        'dealership_id' => '7869254a-4fff-408a-a001-a97113c7a086',
        'VINN_SIGNING_SECRET' => 'adslfkjasldfjk',
        'button_position' => 'afterend',
        'button_container' => '#details-page-ctabox > div.ctabox-inner > p',
        'button_code' => 'class="button primary-button block"',
        'button_text' => 'CHECKOUT',
),
);