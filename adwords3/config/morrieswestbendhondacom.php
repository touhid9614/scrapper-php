<?php

global $CronConfigs;

$CronConfigs["morrieswestbendhondacom"] = array (
  'name' => 'morrieswestbendhondacom',
  'email' => 'regan@smedia.ca',
  'password' => 'morrieswestbendhondacom',
  'log' => true,
  "fb_new_title" => "New [year] [make] [model] [price]",
    "fb_used_title" => "Pre-Owned [year] [make] [model] [price]",
    "fb_certified_title" => "Certified Pre-Owned [year] [make] [model] [price]",
  'customer_id' => '532-585-5715',
  'max_cost' => 8500,
  'cost_distribution' => 
  array (
    'adwords' => 8500,
  ),
  'banner' => 
  array (
    'template' => 'morrieswestbendhondacom',
    'fb_description_new' => 'Are you still interested in the New [year] [make] [model]? Click for more info!',
        'fb_description_used' => 'Are you still interested in the Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_description_certified' => 'Are you still interested in the Certified Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_lookalike_description_new' => 'Check out this New [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_used' => 'Check out this Pre-Owned [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_certified' => 'Check out this Certified Pre-Owned [year] [make] [model] today. Click for more information.',
    'fb_description_2019' => 'Save BIG on all 2019 models! Not comfortable coming into the dealership? We deliver!',
    
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