<?php

global $CronConfigs;
$CronConfigs["beancars"] = array(
    'password' => 'beancars',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'customer_id' => '348-758-6111',
    'max_cost' => 1950,
    'cost_distribution' => array(
        'adwords' => 1950,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'banner' => array(
        'template' => 'beancars',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_marketplace_description' => '[description]',
        'fb_alt_marketplace_description' => '[year] [make] [model]. Check it out today!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'lead' => null,
    'name' => 'beancars',
);