<?php

global $CronConfigs;
$CronConfigs["bannisterchevcom"] = array(
    'password' => 'bannisterchevcom',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'customer_id' => '426-206-8061',
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'banner' => array(
        'template' => 'bannisterchevcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
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
    'form_live' => false,
    'buttons_live' => false,
    'name' => 'bannisterchevcom',
);