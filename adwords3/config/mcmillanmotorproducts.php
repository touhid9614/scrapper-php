<?php

global $CronConfigs;
$CronConfigs["mcmillanmotorproducts"] = array(
    'password' => 'mcmillanmotorproducts',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 150,
    'cost_distribution' => array(
        'adwords' => 150,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => no,
        "new_placement" => no,
        "used_placement" => no,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => no,
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
    "customer_id" => "776-670-2119",
    "banner" => array(
        "template" => "mcmillanmotorproducts",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
),
    'lead_to' => array(
        'edew1717@gmail.com',
        'mcmillanmotorproducts@sasktel.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Request a Quote',
                        'Get a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F08400,#F08400)',
                        'border-color' => 'F08400',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF7200,#CF7200)',
                        'border-color' => 'CF7200',
                        'color' => '#fff',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#504538,#504538)',
                        'border-color' => '504538',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#342D25,#342D25)',
                        'border-color' => '342D25',
                        'color' => '#fff',
),
),
                'blue-green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3E5C77,#3E5C77)',
                        'border-color' => '3E5C77',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#31495E,#31495E)',
                        'border-color' => '31495E',
                        'color' => '#fff',
),
),
),
],
],
);