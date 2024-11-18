<?php

global $CronConfigs;
$CronConfigs["hondaofhotsprings"] = array(
    "name" => "hondaofhotsprings",
    "email" => "regan@smedia.ca",
    "password" => "hondaofhotsprings",
    "log" => true,
    'max_cost' => 800,
    'cost_distribution' => array(
        'adwords' => 800,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
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
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '956-441-0688',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "hondaofhotsprings",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'orrhondahs@eleadtrack.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_widget_3123_sub_section_1 div.first_pricing_btn div.get-e-price',
            'css-class' => 'div.multi_widget_3123_sub_section_1 div.first_pricing_btn div.get-e-price',
            'css-hover' => 'div.multi_widget_3123_sub_section_1 div.first_pricing_btn div.get-e-price:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.multi_widget_3123_sub_section_1 div.first_pricing_btn div.get-e-price',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Price',
                        'Get Your Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
        'get-lease' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price ',
            'css-class' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price ',
            'css-hover' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price :hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'get-lease' => [
                    'target' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price ',
                    'values' => array(
                        'Calculate Lease Payment',
                        'Payment options',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_inner a[href*=finance-application]',
            'css-class' => 'div.multi_cta_inner a[href*=finance-application]',
            'css-hover' => 'div.multi_cta_inner a[href*=finance-application]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.multi_cta_inner a[href*=finance-application]',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_inner a[href*=value-trade-in]',
            'css-class' => 'div.multi_cta_inner a[href*=value-trade-in]',
            'css-hover' => 'div.multi_cta_inner a[href*=value-trade-in]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.multi_cta_inner a[href*=value-trade-in]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
        'confirm-availability' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
            'css-class' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
            'css-hover' => 'div.multi_cta_wrapper div:nth-of-type(3) a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'confirm-availability' => [
                    'target' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
                    'values' => array(
                        'Check Availability',
                        'Ask For Availability',
                        'Get Availability',
                        'Ask for Availability',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/auto\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_wrapper div:nth-of-type(4) a',
            'css-class' => 'div.multi_cta_wrapper div:nth-of-type(4) a',
            'css-hover' => 'div.multi_cta_wrapper div:nth-of-type(4) a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'get-lease' => [
                    'target' => 'div.multi_cta_wrapper div:nth-of-type(4) a',
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
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
),
),
),
],
],
);