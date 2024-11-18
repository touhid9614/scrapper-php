<?php

global $CronConfigs;

$CronConfigs["kamloopskiacom"] = array (
  'name' => 'kamloopskiacom',
  'email' => 'regan@smedia.ca',
  'password' => 'kamloopskiacom',
  'log' => true,
  //'bing_account_id' => 156004302,
  'combined_feed_mode' => true,
  'customer_id' => '277-603-5243',
  'max_cost' => 600,
  'cost_distribution' => 
  array (
    'adwords' => 600,
  ),
  'banner' => 
  array (
    'template' => 'kamloopskiacom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);