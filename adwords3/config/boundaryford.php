<?php

global $CronConfigs;
$CronConfigs["boundaryford"] = array(
    'password' => 'boundaryford',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 490,
    'combined_feed_mode' => true,
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
    'new_title2' => 'See Inventory, Prices & Offers',
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
            "description2" => "Up To 120% of Market Value on Your Trade. See Inventory, Specs & Get a Quote!",
),
        array(
            "description2" => "Up To 120% of Market Value on Your Trade. See Inventory, Specs & Get a Quote!",
),
),
    "customer_id" => "243-548-6957",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "boundaryford",
        "fb_marketplace_description" => "[description]",
        // includes MSRP & Sale Price
        "fb_retargeting_description_new" => "Are you still interested in the [year] [make] [model] [trim]? MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] [trim] today! MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_retargeting_description_used" => "Are you still interested in the [year] [make] [model]? Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_lookalike_description_used" => "Check out this [year] [make] [model] today! Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_retspecial_description_new" => "Are you still interested in the [year] [make] [model]? MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_lalspecial_description_new" => "Check out this [year] [make] [model] today! MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_retspecial_description_used" => "Are you still interested in the [year] [make] [model]? Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_lalspecial_description_used" => "Check out this [year] [make] [model] today! Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_retspringsmash_description_new" => "Are you still interested in the [year] [make] [model]? MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_lalspringsmash_description_new" => "Check out this [year] [make] [model] today! MSRP [msrp]. Sale price [price] + Applicable Taxes. AMVIC Licensed Dealership.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your information, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "ffffff",
),
    'lead_to' => array(
        'Marketing@boundaryford.com',
),
    'adf_to' => array(
        'leads@boundaryford.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target*=vdp_button_widget-3-modal]',
            'css-class' => '[data-target*=vdp_button_widget-3-modal]',
            'css-hover' => '[data-target*=vdp_button_widget-3-modal]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '[data-target*=vdp_button_widget-3-modal]',
                    'values' => array(
                        'Request a Test Drive',
                        'Want to Test Drive?',
                        'Bring me the ride',
                        'REQUEST A TEST RIDE',
                        'TEST RIDE',
                        'SCHEDULE A TEST DRIVE',
                        'WANT TO TEST RIDE?',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6506,#FF6506)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C73005,#C73005)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A531,#00A531)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '359D22',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0083F1,#0083F1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target*=vdp-inquire-modal]',
            'css-class' => '[data-target*=vdp-inquire-modal]',
            'css-hover' => '[data-target*=vdp-inquire-modal]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '[data-target*=vdp-inquire-modal]',
                    'values' => array(
                        'Get Special Price',
                        'More Info',
                        'Request More Info',
                        'Learn More',
                        'Request Information',
                        'Local Pricing',
                        'Local price',
                        'Get Your Local price',
                        'Get our best price',
                        'Get Your Best Price',
                        'Best Price',
                        'Track price',
                        'Get Price Updates',
                        'Price Updates',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6506,#FF6506)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C73005,#C73005)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A531,#00A531)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '359D22',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0083F1,#0083F1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'cost_distribution' => array(),
);