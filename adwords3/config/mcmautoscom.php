<?php

global $CronConfigs;
$CronConfigs["mcmautoscom"] = array(
    'name' => 'mcmautoscom',
    'email' => 'regan@smedia.ca',
    'password' => 'mcmautoscom',
    'log' => true,
    'customer_id' => '779-503-4276',
    'combined_feed_mode' => true,
    'fb_title' => "[year] [make] [model] [trim] price [msrp] + D&H price $499",
    'banner' => array(
        'template' => 'mcmautoscom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 500,
    'cost_distribution' => array(
        'used' => 500,
),
);