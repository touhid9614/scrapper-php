<?php

global $CronConfigs;

$CronConfigs["hcjb"] = array (
  'name' => 'hcjb',
  'email' => 'regan@smedia.ca',
  'password' => 'hcjb',
  'log' => true,
  'customer_id' => '349-641-7000',
  'max_cost' => 410,
  'cost_distribution' => 
  array (
    'adwords' => 410,
  ),
  'banner' => 
  array (
    'template' => 'hcjb',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);