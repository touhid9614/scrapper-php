<?php

global $CronConfigs;

$CronConfigs["westendlincoln"] = array (
  'name' => 'westendlincoln',
  'email' => 'regan@smedia.ca',
  'password' => 'westendlincoln',
  'log' => true,
  "fb_new_title" => "New [year] [make] [model] [price]",
    "fb_used_title" => "Pre-Owned [year] [make] [model] [price]",
    "fb_certified_title" => "Certified Pre-Owned [year] [make] [model] [price]",  
  'max_cost' => 3445,
  'cost_distribution' => 
  array (
    'adwords' => 3445,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '874-468-6933',
  'banner' => 
  array (
    'template' => 'westendlincoln',
    'fb_description_new' => 'Are you still interested in the New [year] [make] [model]? Click for more info!',
        'fb_description_used' => 'Are you still interested in the Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_description_certified' => 'Are you still interested in the Certified Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_lookalike_description_new' => 'Check out this New [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_used' => 'Check out this Pre-Owned [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_certified' => 'Check out this Certified Pre-Owned [year] [make] [model] today. Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'fb_style' => 'morries',
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