<?php

global $CronConfigs;

$CronConfigs["estevanmotors"] = array (
  'name' => 'estevanmotors',
  'email' => 'regan@smedia.ca',
  'password' => 'estevanmotors',
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
  'customer_id' => '913-873-3864',
  'banner' => 
  array (
    'template' => 'estevanmotors',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => true,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'lead_type_service' => false,
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
       '#C3002F',
       '#C3002F',
    ),
    'button_color_hover' => 
    array (
       '#600118',
       '#600118',
    ),
    'button_color_active' => 
    array (
       '#600118',
       '#600118',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 pre-paid VISA giveaway from Estevan Motors LTD',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Estevan Motors LTD Team',
    'forward_to' => 
    array (
       'dustin@estevanmotors.com',
       'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
       '',
    ),
    'special_email' => '',
    'display_after' => 30000,
    'retarget_after' => 5000,
    'fb_retarget_after' => 5000,
    'adword_retarget_after' => 5000,
    'visit_count' => 0,
    'video_url' => '',
    'video_title' => '',
    'video_description' => '',
    'lead_in' => 
    array (
      'vdp' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);