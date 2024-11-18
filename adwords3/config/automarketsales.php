<?php

global $CronConfigs;

$CronConfigs["automarketsales"] = array (
  'bid' => 3.0,
  'password' => 'automarketsales',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'email' => 'regan@smedia.ca',
  'lead' => 
  array (
    'live' => true,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#efefef',
    'text_color' => '#404450',
    'border_color' => '#e5e5e5',
    'button_color' => 
    array (
       '#9929bd',
       '#9929bd',
    ),
    'button_color_hover' => 
    array (
       '#000000',
       '#000000',
    ),
    'button_color_active' => 
    array (
       '#1a3972',
       '#1a3972',
    ),
    'button_text_color' => '#ffffff',
    'response_email_subject' => '$200 OFF offer from SK Automarket Sales',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>SK Automarket Sales Team',
    'forward_to' => 
    array (
       'kscars@hotmail.com',
       'IANdumansky@hotmail.com',
       'wolfman19731@hotmail.com',
       'rhoskins7715@gmail.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/vehicle\\//i',
      'service_regex' => '',
    ),
  ),
  'banner' => 
  array (
    'template' => 'automarketsales',
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
  'name' => 'automarketsales',
);