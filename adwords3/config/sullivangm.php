<?php

global $CronConfigs;

$CronConfigs["sullivangm"] = array (
  'bid' => 3.0,
  'bid_modifier' => 
  array (
    'after' => 45,
    'bid' => 1.5,
  ),
  'password' => 'sullivangm',
  'max_cost' => 1530,
  'cost_distribution' => 
  array (
    'adwords' => 1530,
    'youtube' => 0,
  ),
  'email' => 'regan@smedia.ca',
  'post_code' => 'VOJ 1z0',
  'log' => true,
  'create' => 
  array (
    "new_search" => yes,
    "used_search" => yes,
    'special_search' => false,
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'shown_cap' => false,
    'fillup_cap' => false,
    'session_close' => false,
    'device_type' => 
    array (
      'mobile' => true,
      'desktop' => true,
      'tablet' => true,
    ),
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
      0 => '#597BC0',
      1 => '#597BC0',
    ),
    'button_color_hover' => 
    array (
      0 => '#2C4579',
      1 => '#2C4579',
    ),
    'button_color_active' => 
    array (
      0 => '#2C4579',
      1 => '#2C4579',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$300 offer from Sullivan GM',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sullivan GM Team',
    'forward_to' => 
    array (
      0 => 'kharris@sullivangm.com',
      1 => 'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
      0 => '',
    ),
    'special_email' => '',
    'display_after' => 30000,
    'retarget_after' => 5000,
    'fb_retarget_after' => 5000,
    'adword_retarget_after' => 5000,
    'visit_count' => 0,
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/i',
      'service_regex' => '',
    ),
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
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'special_descs' => 
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
  'options_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Equipped with [option]',
      'desc2' => 'and [option]',
    ),
  ),
  'ymmcount_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'We have [ymmcount] [make]',
      'desc2' => '[model] in stock',
    ),
  ),
  'customer_id' => '641-908-1085',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'sullivangm',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_marketbuyers' => 'custom_banner',
      'used_marketbuyers' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'name' => 'sullivangm',
);