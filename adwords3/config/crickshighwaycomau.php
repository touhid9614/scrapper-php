<?php

global $CronConfigs;

$CronConfigs["crickshighwaycomau"] = array (
  'name' => 'crickshighwaycomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwaycomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwaycomau',
    'fb_description' => '[description]',

    'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',

    
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);