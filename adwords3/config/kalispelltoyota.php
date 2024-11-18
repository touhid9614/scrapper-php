<?php

global $CronConfigs;

$CronConfigs["kalispelltoyota"] = array (
  'name' => 'kalispelltoyota',
  'email' => 'regan@smedia.ca',
  'password' => 'kalispelltoyota',
  'log' => true,
  'max_cost' => 150,
  'cost_distribution' => 
  array (
    'adwords' => 150,
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
  'customer_id' => '764-880-3515',
  'fb_title' => '[year] [make] [model] [trim] - [price]',
  'banner' => 
  array (
    'template' => 'kalispelltoyota',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'fb_marketplace_description' => '[description] Price does not include $297 Office Processing Fee, any state sales tax, or license fees. Payments are estimated only and are subject to credit approval. All vehicles are subject to prior sale. Please contact us to verify price, options, features, mileage, and availability prior to purchase. Best Price includes all dealer discounts.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);