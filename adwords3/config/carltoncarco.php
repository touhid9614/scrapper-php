<?php

global $CronConfigs;

$CronConfigs["carltoncarco"] = array (
  'name' => 'carltoncarco',
  'email' => 'regan@smedia.ca',
  'password' => 'carltoncarco',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'adwords' => 0,
  ),
  'create' => 
  array (
  ),
  'new_title2' => 'See Inventory, Prices & Offers',
  'new_descs' => 
  array (
     
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
     
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
     
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
     
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '804-493-9523',
  'banner' => 
  array (
    'template' => 'carltoncarco',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
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
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
       '#0E1B6A',
       '#0E1B6A',
    ),
    'button_color_hover' => 
    array (
       '#0A0A0A',
       '#0A0A0A',
    ),
    'button_color_active' => 
    array (
       '#0A0A0A',
       '#0A0A0A',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off voucher from Carlton Car',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Carlton Car Team',
    'forward_to' => 
    array (
       'jennifercarlton71@gmail.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/(?:New|Certified|Used)-[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);