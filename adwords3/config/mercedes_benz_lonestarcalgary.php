<?php

global $CronConfigs;
$CronConfigs["mercedes_benz_lonestarcalgary"] = array(
    "name" => "mercedes_benz_lonestarcalgary",
    "email" => "regan@smedia.ca",
    "password" => "mercedes_benz_lonestarcalgary",
    "log" => true,
    //"fb_title" => "[year] [make] [model] - [body_style]",
    "banner" => array(
        "template" => "mercedes_benz_lonestarcalgary",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information. Stock #[stock_number]. Our price [price] + Applicable Taxes.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information. Stock #[stock_number]. Our price [price] + Applicable Taxes.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    //    'lead_to' => array(
    //
    //    ),
    //'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.accordion-opener.btn.btn-secondary',
            'css-class' => 'a.accordion-opener.btn.btn-secondary',
            'css-hover' => 'a.accordion-opener.btn.btn-secondary:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.accordion-opener.btn.btn-secondary',
                    'values' => array(
                        'Get Current Market Price',
                        'Get Special Price Today',
                        'Get Your Exclusive Price',
                        'Get Price Updates',
                        'Get Best Price',
                        'Get Internet Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D9534F,#D9534F)',
                        'border-color' => 'D9534F',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#993A37,#993A37)',
                        'border-color' => '993A37',
                        'color' => '#fefefe',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ADEF,#00ADEF)',
                        'border-color' => '00ADEF',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#007EB0,#007EB0)',
                        'border-color' => '007EB0',
                        'color' => '#fefefe',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-secondary.btn-dealer',
            'css-class' => 'a.btn.btn-secondary.btn-dealer',
            'css-hover' => 'a.btn.btn-secondary.btn-dealer:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.btn.btn-secondary.btn-dealer',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D9534F,#D9534F)',
                        'border-color' => 'D9534F',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#993A37,#993A37)',
                        'border-color' => '993A37',
                        'color' => '#fefefe',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ADEF,#00ADEF)',
                        'border-color' => '00ADEF',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#007EB0,#007EB0)',
                        'border-color' => '007EB0',
                        'color' => '#fefefe',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-secondary.btn-block',
            'css-class' => 'a.btn.btn-secondary.btn-block',
            'css-hover' => 'a.btn.btn-secondary.btn-block:hover',
            /*
            'button_action' => [
                            'form',
                            'trade-in',
                        ],
            */
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a.btn.btn-secondary.btn-block',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                        'Appraise Your Trade',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D9534F,#D9534F)',
                        'border-color' => 'D9534F',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#993A37,#993A37)',
                        'border-color' => '993A37',
                        'color' => '#fefefe',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ADEF,#00ADEF)',
                        'border-color' => '00ADEF',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#007EB0,#007EB0)',
                        'border-color' => '007EB0',
                        'color' => '#fefefe',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fefefe',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#666666,#666666)',
                        'border-color' => '666666',
                        'color' => '#fefefe',
),
),
),
],
],
);