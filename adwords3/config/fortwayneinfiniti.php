<?php

global $CronConfigs;

$CronConfigs["fortwayneinfiniti"] = array (
  'name' => 'fortwayneinfiniti',
  'email' => 'regan@smedia.ca',
  'password' => 'fortwayneinfiniti',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'fortwayneinfiniti',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#efefef',
    'text_color' => '#404450',
    'border_color' => '#e5e5e5',
    'button_color' => 
    array (
       '#000000',
       '#000000',
    ),
    'button_color_hover' => 
    array (
       '#222222',
       '#222222',
    ),
    'button_color_active' => 
    array (
       '#222222',
       '#222222',
    ),
    'button_text_color' => '#ffffff',
    'response_email_subject' => '$200 OFF from Infinity of Fort Wayne',
    'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Infinity of Fort Wayne Team',
    'forward_to' => 
    array (
       'leads@fortwaynenissan.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/',
      'service_regex' => '',
    ),
  ),
);