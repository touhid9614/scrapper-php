<?php

global $CronConfigs;
$CronConfigs["boeckmanford"] = array(
    "name" => "boeckmanford",
    "email" => "regan@smedia.ca",
    "password" => "boeckmanford",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "banner" => array(
        "template" => "boeckmanford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information. Stock #-[stock_number].",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information. Stock #-[stock_number].",
        //	"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead_to' => array(
        'boeckman@pldi.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Your Best Price!',
                        'Get Special Price',
                        'Get Your Price',
                        'Confirm Availability',
                        'Special Pricing!',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-primary.btn-block.calculate',
            'css-class' => 'a.btn.btn-primary.btn-block.calculate',
            'css-hover' => 'a.btn.btn-primary.btn-block.calculate:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a.btn.btn-primary.btn-block.calculate',
                    'values' => array(
                        'Special Finance Offers!',
                        'Estimate Payments',
                        'Financing Options',
                        'Calculate my Payments',
                        'Payment options',
                        'Explore Payments',
                        'Financing Available',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
            'css-class' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
            'css-hover' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1):hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
                    'values' => array(
                        'Schedule My Visit',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
            'css-class' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
            'css-hover' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
                    'values' => array(
                        'Get More Information',
                        'More Info',
                        'Ask a Question!',
                        'Ask an Expert',
                        'More information',
                        'Get More Details',
                        'Get Availability',
                        'Confirm Availability',
                        'Request More Info',
                        'Ask for Availability',
                        'Want to Learn More?',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
            'css-class' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
            'css-hover' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4):hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
                    'values' => array(
                        'Trade Offer',
                        'We Want Your Car',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
        'apply-for-credit' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
            'css-class' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
            'css-hover' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'apply-for-credit' => [
                    'target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
                    'values' => array(
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Apply for Financing',
                        'Get Prequalified for Credit',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1F4581',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '951DBA',
),
),
                'platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#948D7A,#948D7A)',
                        'border-color' => 'BE29EC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#787263,#787263)',
                        'border-color' => '951DBA',
),
),
),
],
],
);