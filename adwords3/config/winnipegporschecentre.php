<?php

global $CronConfigs;
$CronConfigs["winnipegporschecentre"] = array(
    'name' => 'winnipegporschecentre',
    'log' => true,
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'knightvw',
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
),
    "email" => "regan@smedia.ca",
    //tracker
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
    "customer_id" => "238-737-0480",
    "banner" => array(
        "template" => "winnipegporschecentre",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#000",
        'fb_style' => 'fb_new_rightsidebar',
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#151515",
),
    'adf_to' => array(
        '5723@strathcomadf.mailgun.org',
        'shahadathossainece08@gmail.com',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/inventory\\/(?:new|certified|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.vehicle-detail-cta a[href *=testdrive]',
            'css-class' => 'div.vehicle-detail-cta a[href *=testdrive]',
            'css-hover' => 'div.vehicle-detail-cta a[href *=testdrive]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.vehicle-detail-cta a[href *=testdrive]',
                    'values' => array(
                        '<i class="glyphicon"></i>Test drive',
                        '<i class="glyphicon"></i>Book Test Drive',
                        '<i class="glyphicon"></i>Schedule Test Drive',
                        '<i class="glyphicon"></i>Test Drive Now',
                        '<i class="glyphicon"></i>Test Drive today',
                        '<i class="glyphicon"></i>Want to Test Drive It?',
                        '<i class="glyphicon"></i>Request a Test Drive',
                        '<i class="glyphicon"></i>More Information',
                        '<i class="glyphicon"></i>WANT TO TEST RIDE?',
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
                        'background' => 'linear-gradient(#F02F20,#F02F20)',
                        'border-color' => 'F02F20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18B834,#18B834)',
                        'border-color' => '18B834',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#30919A,#30919A)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:new|certified|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.trade-in-appraisal-cta',
            'css-class' => 'a.trade-in-appraisal-cta',
            'css-hover' => 'a.trade-in-appraisal-cta:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a.trade-in-appraisal-cta',
                    'values' => array(
                        '<i class="glyphicon"></i>Trade-In Offer',
                        '<i class="glyphicon"></i>Trade In Your Ride',
                        '<i class="glyphicon"></i>Trade Offer',
                        '<i class="glyphicon"></i>Trade Appraisal',
                        '<i class="glyphicon"></i>Get Trade-In Value',
                        '<i class="glyphicon"></i>APPRAISE YOUR TRADE',
                        '<i class="glyphicon"></i>Value your trade',
                        '<i class="glyphicon"></i>What\'s your trade worth?',
                        '<i class="glyphicon"></i>WHAT\'S YOUR TRADE WORTH?',
                        '<i class="glyphicon"></i>Trade-In Appraisal',
                        '<i class="glyphicon"></i>TRADE-IN OFFER',
                        '<i class="glyphicon"></i>TRADE APPRAISAL',
                        '<i class="glyphicon"></i>TRADE-IN APPRAISAL',
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
                        'background' => 'linear-gradient(#F02F20,#F02F20)',
                        'border-color' => 'F02F20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18B834,#18B834)',
                        'border-color' => '18B834',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#30919A,#30919A)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '30919A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '30919A',
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