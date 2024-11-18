<?php

global $CronConfigs;

$CronConfigs["natchezfordcom"] = array (
  'name' => 'natchezfordcom',
  'email' => 'regan@smedia.ca',
  'password' => 'natchezfordcom',
  'log' => true,
  'max_cost' => 699,
  'cost_distribution' => array(
        'adwords' => 699,
         ),
  "customer_id" => "562-905-0044",
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'natchezfordcom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);