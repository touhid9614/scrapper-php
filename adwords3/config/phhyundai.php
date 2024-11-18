<?php

global $CronConfigs;
$CronConfigs["phhyundai"] = array(
    'name' => 'phhyundai',
    'email' => 'regan@smedia.ca',
    'password' => 'phhyundai',
    'log' => true,
    'customer_id' => '571-448-0792',
    'banner' => array(
        'template' => 'phhyundai',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 40,
        'used' => 360,
),
);