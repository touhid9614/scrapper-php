<?php

global $CronConfigs;
$CronConfigs["sunsetcountryfordcom"] = array(
    'name' => 'sunsetcountryfordcom',
    'email' => 'regan@smedia.ca',
    'password' => 'sunsetcountryfordcom',
    'log' => true,
    'banner' => array(
        'template' => 'sunsetcountryfordcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 975,
    'cost_distribution' => array(
        'new' => 725,
        'used' => 250,
),
);