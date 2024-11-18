<?php

global $CronConfigs;
$CronConfigs["kelownahonda"] = array(
    'name' => 'kelownahonda',
    'email' => 'regan@smedia.ca',
    'password' => 'kelownahonda',
    'log' => true,
    'max_cost' => 300,
    'cost_distribution' => array(
        'adwords' => 300,
),
    'customer_id' => '790-184-6421',
    'banner' => array(
        'template' => 'kelownahonda',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'fb_marketplace_description' => '[description]',
),
    'lead' => null,
);