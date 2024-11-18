<?php

global $CronConfigs;

$CronConfigs["drumhellerchrysler"] = array (
  'name' => 'drumhellerchrysler',
  'email' => 'regan@smedia.ca',
  'password' => 'drumhellerchrysler',
  'log' => true,
  'banner' => 
  array (
    'template' => 'drumhellerchrysler',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => true,
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
       '#C3002F',
       '#C3002F',
    ),
    'button_color_hover' => 
    array (
       '#AA0025',
       '#AA0025',
    ),
    'button_color_active' => 
    array (
       '#AA0025',
       '#AA0025',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$250 off coupon from Drumheller Chrysler',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Drumheller Chrysler Team',
    'forward_to' => 
    array (
       'scott@drumhellerchrysler.com',
       'rt@drumhellerchrysler.com',
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
      'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);