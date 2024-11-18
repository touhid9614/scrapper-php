<?php

global $CronConfigs;

$CronConfigs["hayeschevroletcom"] = array (
  'name' => 'hayeschevroletcom',
  'email' => 'regan@smedia.ca',
  'password' => 'hayeschevroletcom',
  'log' => true, 
  "combined_feed_mode" => true,
  'customer_id' => '304-324-4884',
  'max_cost' => 1125,
    'fb_title' => '[year] [make] [model]',
  'cost_distribution' => 
  array (
    'adwords' => 1125,
  ),
  'banner' => 
  array (
    'template' => 'hayeschevroletcom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);