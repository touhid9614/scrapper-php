<?php

global $CronConfigs;
$CronConfigs["performancekiaca"] = array(
    'name' => 'performancekiaca',
    'email' => 'regan@smedia.ca',
    'password' => 'performancekiaca',
    'log' => true,
    'customer_id' => '110-970-9995',
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'performancekiaca',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 582,
    'cost_distribution' => array(
        'new' => 582,
        'used' => 0,
),
);