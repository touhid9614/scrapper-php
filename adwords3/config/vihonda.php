<?php

global $CronConfigs;
$CronConfigs["vihonda"] = array(
    'name' => 'vihonda',
    'email' => 'regan@smedia.ca',
    'password' => 'vihonda',
    'log' => true,
    'banner' => array(
        'template' => 'vihonda',
      //  'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
       // 'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description' => 'Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        //'fb_marketplace_description' => '[description]',
),
    'lead' => null,
);