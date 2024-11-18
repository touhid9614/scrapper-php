<?php

global $CronConfigs;
$CronConfigs["revolutionautogroup"] = array(
    "name" => " revolutionautogroup",
    "email" => "regan@smedia.ca",
    "password" => " revolutionautogroup",
    "log" => true,
    "banner" => array(
        "template" => "revolutionautogroup",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'imakarov@revolutionautogroup.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/ca\\/en-CA\\/(?:new|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.action-calls-buttons div div  .contact-me',
            'css-class' => '.action-calls-buttons div div  .contact-me',
            'css-hover' => '.action-calls-buttons div div  .contact-me:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.action-calls-buttons div div  .contact-me',
                    'values' => array(
                        'Get More Info',
                        'Request More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask Our Expert',
                        'More Info',
                        'Learn More',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3F99E5,#3F99E5)',
                        'border-color' => '0B498A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F36342,#F36342)',
                        'border-color' => 'C3002F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2FAF63,#2FAF63)',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F4BC00,#F4BC00)',
                        'border-color' => '45BA00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
),
],
        'financing' => [
            'url-match' => '/ca\\/en-CA\\/(?:new|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.action-calls-buttons div div .car-loan',
            'css-class' => '.action-calls-buttons div div .car-loan',
            'css-hover' => '.action-calls-buttons div div .car-loan:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.action-calls-buttons div div .car-loan',
                    'values' => array(
                        'Get Financed Today',
                        'No Hassle Financing',
                        'Financing Available',
                        'Special Finance Offers',
                        'Get Pre-Approved',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3F99E5,#3F99E5)',
                        'border-color' => '0B498A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F36342,#F36342)',
                        'border-color' => 'C3002F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2FAF63,#2FAF63)',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F4BC00,#F4BC00)',
                        'border-color' => '45BA00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
),
],
        'trade-in' => [
            'url-match' => '/ca\\/en-CA\\/(?:new|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.action-calls-buttons div div .exchange',
            'css-class' => '.action-calls-buttons div div .exchange',
            'css-hover' => '.action-calls-buttons div div .exchange:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '.action-calls-buttons div div .exchange',
                    'values' => array(
                        'Appraise Your Trade',
                        'Trade-In Appraisal',
                        'Value Your Trade',
                        'Get Trade-In Value',
                        'What’s Your Trade Worth?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3F99E5,#3F99E5)',
                        'border-color' => '0B498A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F36342,#F36342)',
                        'border-color' => 'C3002F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2FAF63,#2FAF63)',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F4BC00,#F4BC00)',
                        'border-color' => '45BA00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
),
],
        'contact-us' => [
            'url-match' => '/ca\\/en-CA\\/(?:new|used)\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.action-calls-buttons div div .contact-us',
            'css-class' => '.action-calls-buttons div div .contact-us',
            'css-hover' => '.action-calls-buttons div div .contact-us:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'contact-us' => [
                    'target' => '.action-calls-buttons div div .contact-us',
                    'values' => array(
                        'Call Us Now',
                        'Call Us Today',
                        'Contact Us Now',
                        'Contact Us Today',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3F99E5,#3F99E5)',
                        'border-color' => '0B498A',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F36342,#F36342)',
                        'border-color' => 'C3002F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2FAF63,#2FAF63)',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F4BC00,#F4BC00)',
                        'border-color' => '45BA00',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => '1A1A1A',
                        'color' => '#1A1A1A',
),
),
),
],
],
);