<?php

global $CronConfigs;
$CronConfigs["wheatonsaskatoon"] = array(
    'password' => 'wheatonsaskatoon',
    "email" => "regan@smedia.ca",
    'log' => true,
    'customer_id' => '614-413-6327',
    'max_cost' => 1850,
    'cost_distribution' => array(
        'adwords' => 1850,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
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
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "wheatonsaskatoon",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        //'fb_description_2019_sierra 1500' => "Are you still interested in the [year] [make] [model]? Get up to 15% of MSRP cash credit on select  2019 Sierras and Silverados or finance for as low as 0% for up to 84 months! Shop below now as this offer ends soon!",
        //'fb_description_2019_silverado 1500' => "Are you still interested in the [year] [make] [model]? Get up to 15% of MSRP cash credit on select  2019 Sierras and Silverados or finance for as low as 0% for up to 84 months! Shop below now as this offer ends soon!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
    'lead_to' => array(
        'mpajota@wheatonsaskatoon.com',
        'srobson@wheatonsaskatoon.com',
        'dcollins@wheatonsaskatoon.com',
        'rjjohnson@wheatonsaskatoon.com',
        'scook@wheatonsaskatoon.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-location="vehicle-ask-button"]',
            'css-class' => 'a[data-location="vehicle-ask-button"]',
            'css-hover' => 'a[data-location="vehicle-ask-button"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-location="vehicle-ask-button"]',
                    'values' => array(
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>GET A QUOTE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>REQUEST A QUOTE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>GET E-PRICE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>GET INTERNET PRICE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>GET OUR BEST PRICE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>GET SPECIAL PRICE',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>SPECIAL PRICING',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>INQUIRE NOW',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0000,#DA0000)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9B0828,#9B0828)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00DA00,#00DA00)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#297A1B,#297A1B)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#006DDA,#006DDA)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#005C82,#005C82)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA6D00,#DA6D00)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-location="vehicle-value-a-trade-button"]',
            'css-class' => '[data-location="vehicle-value-a-trade-button"]',
            'css-hover' => '[data-location="vehicle-value-a-trade-button"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '[data-location="vehicle-value-a-trade-button"]',
                    'values' => array(
                        'GET TRADE-IN VALUE',
                        'APPRAISE YOUR TRADE',
                        'TRADE APPRAISAL',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'TRADE-IN OFFER',
                        'WE WANT YOUR RIDE',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0000,#DA0000)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9B0828,#9B0828)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00DA00,#00DA00)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#297A1B,#297A1B)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#006DDA,#006DDA)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#005C82,#005C82)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA6D00,#DA6D00)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-location="vehicle-drive-button"]',
            'css-class' => 'a[data-location="vehicle-drive-button"]',
            'css-hover' => 'a[data-location="vehicle-drive-button"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-location="vehicle-drive-button"]',
                    'values' => array(
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>REQUEST A TEST DRIVE',
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>TEST DRIVE',
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>TEST DRIVE TODAY',
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>SCHEDULE YOUR TEST DRIVE',
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>SCHEDULE YOUR VISIT',
                        '<i class="ddc-icon-size-large ddc-icon-steeringwheel ddc-icon d-block pb-1 text-neutral-800"></i>WANT TO TEST DRIVE IT?',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA0000,#DA0000)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9B0828,#9B0828)',
                        'border-color' => 'A70000',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00DA00,#00DA00)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#297A1B,#297A1B)',
                        'border-color' => '00A700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#006DDA,#006DDA)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#005C82,#005C82)',
                        'border-color' => '0054A7',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DA6D00,#DA6D00)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'A75300',
                        'color' => '#fff',
),
),
),
],
],
);