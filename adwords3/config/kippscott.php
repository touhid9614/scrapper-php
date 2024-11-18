<?php

global $CronConfigs;
$CronConfigs["kippscott"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'kippscott',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '410-866-5491',
    'max_cost' => 3460,
    'cost_distribution' => array(
        'adwords' => 3460,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today. Stock number- [stock_number]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today.  Stock number- [stock_number]",
),
),
    "banner" => array(
        "template" => "kippscott",
        "fb_description_new" => "Are you still interested in the [year] [make] [model] [trim]? MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. Click for more info!",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info. Stock: [stock_number]. Click for more info!",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] today! MSRP [msrp]. Sale price is [price]. Stock: [stock_number]. Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Stock: [stock_number]. Click for more info!",
        "flash_style" => "default",
        "old_price_new" => "msrp",
        "fb_style" => "kippscott",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "params" => array(
            "show_stock" => 'yes',
            //TO SHOW STOCK NUMBER
            "show_tom" => 'no',
),
        "font_color" => "#ffffff",
),
    'lead_to' => array(
        'will.rubottom@scottsville.com',
),
    'adf_to' => array(
        'smedia@kippscott.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}-[^-]/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="647b043f-7e91-4ea8-ba36-558fb43dcea8"]',
            'css-class' => 'a[name="647b043f-7e91-4ea8-ba36-558fb43dcea8"]',
            'css-hover' => 'a[name="647b043f-7e91-4ea8-ba36-558fb43dcea8"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="647b043f-7e91-4ea8-ba36-558fb43dcea8"]',
                    'values' => array(
                        'Inquire Today',
                        'Inquire Now',
                        'Check Availability',
                        'Confirm Availability',
                        'Click Here To Buy Now!',
                        'Get Availability',
                        'Submit Inquiry',
                        'Make an Inquiry',
                        'Consultation',
                        'Interested?',
                        'More Information',
                        'More Info',
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
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}-[^-]/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=Trade-Appraisal].secondary',
            'css-class' => 'a[href*=Trade-Appraisal].secondary',
            'css-hover' => 'a[href*=Trade-Appraisal].secondary:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=Trade-Appraisal].secondary',
                    'values' => array(
                        'Trade Appraisal',
                        'Value your trade',
                        'Appraise Your Trade',
                        'Get Trade-In Value',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'TRADE APPRAISAL',
                        'TRADE-IN OFFER',
                        'TRADE-IN APPRAISAL',
                        'Trade Value',
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
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '188BB7',
),
),
),
],
],
);