<?php

global $CronConfigs;

$CronConfigs["standardmotorsca"] = array (
  'name' => 'standardmotorsca',
  'email' => 'regan@smedia.ca',
  'password' => 'standardmotorsca',
  'log' => true,
  'combined_feed_mode' => true,
  'customer_id' => '982-809-1746',
  'max_cost' => 200,
  'cost_distribution' => 
  array (
    'adwords' => 200,
  ),
  'banner' => 
  array (
    'template' => 'standardmotorsca',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
       'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
);