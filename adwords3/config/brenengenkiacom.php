<?php

global $CronConfigs;

$CronConfigs["brenengenkiacom"] = array (
  'name' => 'brenengenkiacom',
  'email' => 'regan@smedia.ca',
  'password' => 'brenengenkiacom',
  'log' => true,
  "fb_new_title" => "New [year] [make] [model] [price]",
    "fb_used_title" => "Pre-Owned [year] [make] [model] [price]",
    "fb_certified_title" => "Certified Pre-Owned [year] [make] [model] [price]",  
  'combined_feed_mode' => true,
  'customer_id' => '677-025-7135',
  'bing_account_id' => 156004154,
  'max_cost' => 3405,
  'cost_distribution' => 
  array (
    'adwords' => 3405,
  ),
  'banner' => 
  array (
    'template' => 'brenengenkiacom',
    'fb_description_new' => 'Are you still interested in the New [year] [make] [model]? Click for more info!',
        'fb_description_used' => 'Are you still interested in the Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_description_certified' => 'Are you still interested in the Certified Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_lookalike_description_new' => 'Check out this New [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_used' => 'Check out this Pre-Owned [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_certified' => 'Check out this Certified Pre-Owned [year] [make] [model] today. Click for more information.',
    'fb_style' => 'morries',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);