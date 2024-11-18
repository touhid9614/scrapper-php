<?php

global $CronConfigs;

$CronConfigs["edwardsgarage"] = array (
  'password' => 'edwardsgarage',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'customer_id' => '556-377-2536',
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
      'desc2' => '[year] [make] [model] today.',
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
      'desc2' => '[year] [make] [model] today.',
    ),
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
       '#FAC703',
       '#FAC703',
    ),
    'button_color_hover' => 
    array (
       '#E1A504',
       '#E1A504',
    ),
    'button_color_active' => 
    array (
       '#E1A504',
       '#E1A504',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Your first oil change and tire rotation is on us!',
    'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Edwards Garage',
    'forward_to' => 
    array (
       'zachk@edwardsgarage.com',
       'zachkennedy@hotmail.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:New|certified|Used)/i',
      'service_regex' => '',
    ),
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'edwardsgarage',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info! Stock #-[stock_number].',
    'fb_lookalike_description' => 'Interested in this [year] [make] [model]? Check with us today for discounts!. Stock #- [stock_number].',
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
    'font_color' => '#ffffff',
  ),
  'name' => 'edwardsgarage',
);