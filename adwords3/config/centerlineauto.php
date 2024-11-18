<?php

global $CronConfigs;

$CronConfigs["centerlineauto"] = array (
  'name' => 'centerlineauto',
  'email' => 'regan@smedia.ca',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'password' => 'centerlineauto',
  'bing_account_id' => 156004845,
  'log' => true,
  'max_cost' => 300,
  'cost_distribution' => 
  array (
    'adwords' => 300,
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
  'customer_id' => '593-369-1503',
  'fb_title' => '[year] [make] [model]',
  'banner' => 
  array (
    'template' => 'Centerline RV',
    'fb_retargeting_description' => 'Are you still interested in the [year] [make] [model] ? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_marketbuyers' => 'custom_banner',
      'used_marketbuyers' => 'custom_banner',
    ),
  ),
);
