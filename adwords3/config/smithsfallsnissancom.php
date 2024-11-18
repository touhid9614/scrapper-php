<?php

global $CronConfigs;
$CronConfigs["smithsfallsnissancom"] = array(
    'name' => 'smithsfallsnissancom',
    'email' => 'regan@smedia.ca',
    'password' => 'smithsfallsnissancom',
    'log' => true,
    'customer_id' => '775-927-9127',
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'smithsfallsnissancom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 550,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 550,
),
);