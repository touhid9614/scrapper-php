<?php

global $CronConfigs;
$CronConfigs["knightdodgeofweyburn"] = array(
    'name' => 'knightdodgeofweyburn',
    //'budget'    => 2.0,
    'bid' => 3.0,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'password' => 'knightdodgeofweyburn',
    'bing_account_id' => 156002893,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 250,
    'cost_distribution' => array(
        'adwords' => 250,
    ),
    "email" => "marshal@smedia.ca",
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_combined" => yes,
        "new_combined" => yes,
),
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
    "customer_id" => "760-104-7621",
    "banner" => array(
        "template" => "knightdodgeofweyburn",
        //"fb_style" => "facebook_new_ad_custom",
        //'fb_description' => "Are you still interested in the [year] [make] [model]? At Knight Weyburn, you'll receive small town service with big city options. Shop below.",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Shop our inventory from the comfort of your home!",
        //'fb_lookalike_description' => "Check out this [year] [make] [model] today! At Knight Weyburn, you'll receive small town service with big city options. Shop below.",
        'fb_lookalike_description' => "Check out this [year] [make] [model] today. Shop our inventory from the comfort of your home!",
        'fb_clearout_description' => "Shop below for huge savings on our 2018 pre-owned trucks we think you'd be interested in! Hurry, they won't be here for long.",
        "fb_gcleadv1_description" => "Are you interested in the [year] [make] [model]? Click below and fill in your information to find out more about our special offer. A product specialist will be in touch to answer any questions.",
        "fb_gcleadv2_description" => "Are you interested in the [year] [make] [model]? Click below and fill in your information to find out more about our special offer. A product specialist will be in touch to answer any questions.",
        "fb_ram1500leadv1_description" => "Are you interested in the [year] [make] [model]? Click below and fill in your information to find out more about our special offer. A product specialist will be in touch to answer any questions.",
        "fb_ram1500leadv2_description" => "Are you interested in the [year] [make] [model]? Click below and fill in your information to find out more about our special offer. A product specialist will be in touch to answer any questions.",
        'fb_marketplace_description' => '[description]',
        "flash_style" => "default",
        "border_color" => "#000",
        'marketting_lines' => function ($car_data) {
            $retval = [
                'marketing_line1' => "--------------",
                'marketing_line2' => "NOW",
];
            return $retval;
        },
        //"old_price" => "msrp",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "ffffff",
),
    'adf_to' => array(
        'leads@sales.knightweyburn.com',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
            'css-class' => 'a.button.cta-button.block.button-form.fancybox',
            'css-hover' => 'a.button.cta-button.block.button-form.fancybox:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'Get Our Best Price',
                        'Local Pricing',
                        'You are Eligible  for Special Pricing',
                        'Market Pricing',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Get Your Best Price',
                        'E- Price',
                        'Get Sale Price',
                        'GET CURRENT PRICE',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
);