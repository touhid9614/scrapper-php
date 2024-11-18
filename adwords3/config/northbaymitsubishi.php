<?php

global $CronConfigs;
$CronConfigs["northbaymitsubishi"] = array(
    'name' => 'northbaymitsubishi',
    'email' => 'regan@smedia.ca',
    'password' => 'northbaymitsubishi',
    'fb_new_title' => '[year] [make] [model] [finance]+ HST bi-weekly',
    'combined_feed_mode' => true,
    'log' => true,
    'max_cost' => 800,
    'cost_distribution' => array(
        'adwords' => 800,
),
    'customer_id' => '123-221-9009',
    'create' => array(),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the [year]',
            'desc2' => '[make] [model] today',
),
),
    'banner' => array(
        'template' => 'northbaymitsubishi',
        'fb_description' => 'Are you still interested in the [make] [model]? Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => 'ffffff',
),
);