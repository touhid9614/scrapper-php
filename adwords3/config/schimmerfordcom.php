<?php

global $CronConfigs;
$CronConfigs["schimmerfordcom"] = array(
    'name' => 'schimmerfordcom',
    'email' => 'regan@smedia.ca',
    'password' => 'schimmerfordcom',
    'log' => true,
    'banner' => array(
        'template' => 'schimmerfordcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 300,
    'cost_distribution' => array(
        'new' => 150,
        'used' => 150,
),
);