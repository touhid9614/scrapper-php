<?php

global $CronConfigs;

$CronConfigs["msautodirectcom"] = array (
  'name' => 'msautodirectcom',
  'email' => 'regan@smedia.ca',
  'password' => 'msautodirectcom',
  'log' => true,
  'max_cost' => 699,
  'cost_distribution' => array(
        'adwords' => 699,
         ),
  "customer_id" => "778-406-0339",
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'msautodirectcom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);