<?php

global $CronConfigs;
$CronConfigs["adventurervca"] = array(
    'name' => 'adventurervca',
    'email' => 'regan@smedia.ca',
    'password' => 'adventurervca',
    'combined_feed_mode' => true,
    'log' => true,
    'fb_title' => '[make] [model] [price]',
    'banner' => array(
        'template' => 'adventurervca',
        'fb_description' => 'Are you still interested in the [make] [model]? We\'re offering FREE storage with RV purchase. Order now & Pick up in the SPRING!',
        //'fb_aia_description' => 'Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'We\'re offering FREE storage with RV purchase. Order this [make] [model] now & Pick up in the SPRING!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 200,
        'used' => 200,
),
);