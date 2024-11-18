<?php

global $CronConfigs;

$CronConfigs["surreymitsubishi"] = array (
  'name' => 'surreymitsubishi',
  'email' => 'regan@smedia.ca',
  'password' => 'surreymitsubishi',
  'log' => true,
  'banner' => 
  array (
    'template' => 'surreymitsubishi',
    'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',  
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);