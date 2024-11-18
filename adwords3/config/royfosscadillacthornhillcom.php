<?php

global $CronConfigs;
$CronConfigs["royfosscadillacthornhillcom"] = array(
    'name' => 'royfosscadillacthornhillcom',
    'email' => 'regan@smedia.ca',
    'password' => 'royfosscadillacthornhillcom',
    'log' => true,
    "customer_id"   => "461-815-0100",
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'royfosscadillacthornhillcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click to learn more.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today. Click for further information.',
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