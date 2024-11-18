<?php

global $CronConfigs;

$CronConfigs["performancelincolnbountiful"] = array(
    'name' => 'performancelincolnbountiful',
    'email' => 'regan@smedia.ca',
    'password' => 'performancelincolnbountiful',
    'log' => true,
    'fb_title' => '[year] [make] [model] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '997-771-1111',
    'bing_account_id' => 156002908,
    'bing_create' => array(
        'new_search' => true,
    ),
    'max_cost' => 350,
    'create' => array(
        "new_search" => yes,
        "used_search" => yes,
    ),
    'new_descs' => array(
        0 =>
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        1 =>
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs' =>
    array(
        0 =>
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        1 =>
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'banner' => array(
        'template' => 'performancelincolnbountiful',
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
);
