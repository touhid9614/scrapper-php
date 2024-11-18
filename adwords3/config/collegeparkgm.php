<?php

global $CronConfigs;

$CronConfigs["collegeparkgm"] = array (
  'name' => 'collegeparkgm',
  'email' => 'regan@smedia.ca',
  'password' => 'collegeparkgm',
  'log' => true,
  'banner' => 
  array (
    'template' => 'collegeparkgm',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
    'bg_color' => '#efefef',
    'text_color' => '#404450',
    'border_color' => '#e5e5e5',
    'button_color' => 
    array (
       '#61d73e',
       '#61d73e',
    ),
    'button_color_hover' => 
    array (
       '#377525',
       '#377525',
    ),
    'button_color_active' => 
    array (
       '#377525',
       '#377525',
    ),
    'button_text_color' => '#ffffff',
    'response_email_subject' => '$200 off coupon from College Park Motors',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>College Park Motors Team',
    'forward_to' => 
    array (
       'lalward@collegeparkgm.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/VehicleDetails\\//i',
      'service_regex' => '',
    ),
  ),
);