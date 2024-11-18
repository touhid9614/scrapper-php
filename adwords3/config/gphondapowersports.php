<?php

global $CronConfigs;
$CronConfigs["gphondapowersports"] = array(
    'name'              => 'gphondapowersports',
    'email'             => 'regan@smedia.ca',
    'password'          => 'gphondapowersports',
    'log'               => true,
    'fb_title'          => '[year] [make] [model] [trim]',
    // 'max_cost'          => 760,
    // 'cost_distribution' => array(
    //     'adwords' => 760,
    // ),
    'create'            => array(),
    'new_search_title'  => '[model] [trim]',
    'new_search_title2' => '[model] [price]',
    'new_descs'         => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1'  => 'Test Drive the [year]',
            'desc2'  => '[make] [model] today.',
        ),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1'  => 'Call us today about the ',
            'desc2'  => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1'  => 'Test Drive the [year]',
            'desc2'  => '[make] [model] today.',
        ),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1'  => 'Call us today about the ',
            'desc2'  => '[year] [make] [model] today',
        ),
    ),
    // 'customer_id'       => '703-478-1944',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'banner'            => array(
        'template'                 => 'grandeprairiehonda',
        'fb_aia_description'       => "Check out this [year] [make] [model] today! Click the 'Dealership Website' link below for more information.",
        'fb_description'           => "Check out this [year] [make] [model] today! Click the 'Dealership Website' link below for more information.",
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'styels'                   => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
);
