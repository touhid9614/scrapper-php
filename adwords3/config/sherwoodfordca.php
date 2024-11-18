<?php

global $CronConfigs;
$CronConfigs["sherwoodfordca"] = array(
    'name' => 'sherwoodfordca',
    'email' => 'regan@smedia.ca',
    'password' => 'sherwoodfordca',
    'log' => true,
    'combined_feed_mode' => true,
    'fb_title' => '[year] [make] [model]',
    'banner' => array(
        'template' => 'sherwoodfordca',
        'fb_description_new' => "Are you still interested in the [year] [make] [model] - stock: [stock_number]? Click for more information.",
        'fb_lookalike_description_new' => "Check out this [year] [make] [model] - stock: [stock_number] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_description_used' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description_used' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 500,
    'cost_distribution' => array(
        'new' => 250,
        'used' => 250,
),
);