<?php

global $CronConfigs;

$CronConfigs["mcgovernsrv"] = array (
  'name' => 'mcgovernsrv',
  'bid' => 3.0,
  'bid_modifier' => 
  array (
    'after' => 45,
    'bid' => 1.5,
  ),
  'log' => true,
  'max_cost' => 275,
  'email' => 'regan@smedia.ca',
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
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
     '#005379',
     '#005379',
    ),
    'button_color_hover' => 
    array (
      '#033D58',
       '#033D58',
    ),
    'button_color_active' => 
    array (
      '#033D58',
       '#033D58',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Get $300 In Store Credit from McGovern\'s RV & Marine',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer!  Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>McGovern\'s RV & Marine Team',
    'forward_to' => 
    array (
      'koenryden@mcgovernsrv.com',
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
    'lead_in' => 
    array (
      'vdp' => '/\\/default.asp\\?page=x(?:New|PreOwned)InventoryDetail/i',
      'service_regex' => '',
    ),
  ),
  'create' => 
  array (
  ),
  'host_url' => 'http://mcgovernsrv.com/',
  'display_url' => 'mcgovernsrv.com/',
  'new_descs' => 
  array (

    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'used_descs' => 
  array (
 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'customer_id' => '168-387-5406',
  'market_buyers' => 
  array (
    'common' => 
    array (
       1213,
       80069,
    ),
    'new' => 
    array (
    ),
    'used' => 
    array (
    ),
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'mcgovernsrv',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information. Stock #- [stock_number].',
    
    'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',

    'fb_lookalike_description' => 'Check out the [year] [make] [model] today! Click for more information. Stock #- [stock_number].',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to get $300 parts credit with purchase, and a product specialist will be in touch to aid in any questions. Stock #- [stock_number].',
    'flash_style' => 'default',
    'border_color' => '#dbc289',
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
  'cost_distribution' => 
  array (
    'new' => 113,
    'used' => 112,
  ),
  'password' => 'mcgovernsrv',
);