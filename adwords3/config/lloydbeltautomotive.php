<?php

global $CronConfigs;
$CronConfigs["lloydbeltautomotive"] = array(
    "name" => " lloydbeltautomotive",
    "email" => "regan@smedia.ca",
    "password" => " lloydbeltautomotive",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "lloydbeltautomotive",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_description" => "Get a 50\" LED Flat Screen or a PitBoss Pellet Grill when you buy a vehicle at Lloyd Belt Automotive until December 31st only! Plus get the option of no payments for 90 days! There's no better time to buy a vehicle from Lloyd Belt Automotive! ",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
		"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'lloydbeltleads@host.udcnet.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/listings\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'li.request.gradient_button',
            'css-class' => 'li.request.gradient_button',
            'css-hover' => 'li.request.gradient_button a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'li.request.gradient_button a',
                    'values' => array(
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask an Expert',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B2DA9,#1B2DA9)',
                        'border-color' => '1B2DA9',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#132079,#132079)',
                        'border-color' => '132079',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#090909,#090909)',
                        'border-color' => '090909',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '838383',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535353,#535353)',
                        'border-color' => '535353',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/listings\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.schedule.gradient_button',
            'css-class' => '.schedule.gradient_button',
            'css-hover' => '.schedule.gradient_button a:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.schedule.gradient_button a',
                    'values' => array(
                        'Request a Test Drive',
                        'Book a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1B2DA9,#1B2DA9)',
                        'border-color' => '1B2DA9',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#132079,#132079)',
                        'border-color' => '132079',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#090909,#090909)',
                        'border-color' => '090909',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '838383',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535353,#535353)',
                        'border-color' => '535353',
                        'color' => '#fff',
),
),
),
],
],
);