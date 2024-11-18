<?php

global $CronConfigs;

$CronConfigs["evergreennissan"] = array (
  'name' => 'evergreennissan',
  'email' => 'regan@smedia.ca',
  'password' => 'evergreennissan',
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
  'customer_id' => '877-581-2807',
  'bing_account_id' => 156003510,
  'fb_title' => '[year] [make] [model] [price]',
  'banner' => 
  array (
    'template' => 'evergreennissan',
    'fb_description_new' => 'Are you still interested in the [year] [make] [model] [trim]? Click here for more information or give us a call to take it for a test drive!',
    'fb_lookalike_description_new' => 'Check out this [year] [make] [model] [trim]! Click for more information.',
    'fb_description_used' => 'Are you still interested in the [year] [make] [model]? Up To 120% of Market Value on Your Trade! Click here for more information or give us a call to take it for a test drive!',
    'fb_lookalike_description_used' => 'Check out this [year] [make] [model]. Up To 120% of Market Value on Your Trade! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your information, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => 'ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
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
    'sent_client_email' => true,
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
       '#9C0026',
       '#9C0026',
    ),
    'button_color_active' => 
    array (
       '#9C0026',
       '#9C0026',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off coupon from Evergreen Nissan',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Evergreen Nissan Team',
    'forward_to' => 
    array (
       'gsm@evergreennissan.com',
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
    'video_smart_offer' => false,
    'video_smart_offer_form' => false,
    'video_url' => '',
    'video_title' => '',
    'video_description' => '',
    'lead_in' => 
    array (
      'vdp' => '/\\/en\\/(?:new|used)\\-inventory/i',
      'service_regex' => '',
    ),
  ),
);