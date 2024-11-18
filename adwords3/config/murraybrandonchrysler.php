<?php

global $CronConfigs;

$CronConfigs["murraybrandonchrysler"] = array (
  'password' => 'murraybrandonchrysler',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'bid' => 3.0,
  'bid_modifier' => 
  array (
    'after' => 45,
    'bid' => 1.5,
  ),
  'max_cost' => 1300,
  'post_code' => 'R7A 7E3',
  'email' => 'regan@smedia.ca',
  'trackers' => 
  array (
    'new_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'used_search' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'new_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'used_display' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'new_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'new_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    'used_combined' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
  ),
  'create' => 
  array (
  	//"new_search" => true,
  ),
  'smart_ad_url' => 'https://www.murraychryslerwestman.com/all-inventory/index.htm?model=[model]&year=[year]&make=[make]',
  'host_url' => 'https://www.murraychryslerwestman.com',
  'display_url' => 'www.murraychryslerwestman.com',
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
      'desc2' => '[year] [make] [model]',
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
      'desc2' => '[year] [make] [model] ',
    ),
  ),
  'customer_id' => '169-021-3657',
  'banner' => 
  array (
    'template' => 'murraybrandonchrysler',
    'fb_description' => 'Are you still interested in the [Year] [Make] [Model]? Click for more info!',
    'fb_lookalike_description' => 'Test drive the [Year] [Make] [Model] today, come see us at 1550 Richmond Ave. Brandon!',
    'flash_style' => 'default',
    'border_color' => '#2e2e2e',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'cost_distribution' => 
  array (
    'new' => 900,
    'used' => 300,
    'youtube' => 200,
  ),
  'name' => 'murraybrandonchrysler',
);
