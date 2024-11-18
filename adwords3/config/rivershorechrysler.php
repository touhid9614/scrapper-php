<?php

global $CronConfigs;
$CronConfigs["rivershorechrysler"] = array(
    'name' => 'rivershorechrysler',
    'email' => 'regan@smedia.ca',
    'password' => 'rivershorechrysler',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 3000,
    'cost_distribution' => array(
        'adwords' => 3000,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
            'description2' => 'Home of Direct Buy Truck Centre and #1 Used volume Dealer in Kamloops.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
            'description2' => 'Home of Direct Buy Truck Centre and #1 Used volume Dealer in Kamloops.',
),
),
    'customer_id' => '774-051-3798',
    'fb_title' => '[year] [make] [model] [price]',
    'banner' => array(
        'template' => 'rivershorechrysler',
        'old_price_new' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Shop our inventory from the comfort of your home!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Shop our inventory from the comfort of your home!',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'fb_marketplace_description' => '[description]',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => 'ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
);