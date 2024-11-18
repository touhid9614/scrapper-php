<?php

global $CronConfigs;

$CronConfigs["juliojonesmazda"] = array (
  'name' => 'juliojonesmazda',
  'email' => 'regan@smedia.ca',
  'password' => 'juliojonesmazda',
  'log' => true,
  'customer_id' => '848-373-6939',
  'model_map' => 
  array (
    'Mazda' => 
    array (
      3 => 'Mazda3',
      '3 Sport' => 'Mazda3 Sport',
      6 => 'Mazda6',
    ),
  ),
  'max_cost' => 1250,
  'cost_distribution' => 
  array (
    'adwords' => 1250,
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'juliojonesmazda',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);