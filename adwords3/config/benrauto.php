<?php

global $CronConfigs;

$CronConfigs["benrauto"] = array (
  'name' => 'benrauto',
  'email' => 'regan@smedia.ca',
  'password' => 'benrauto',
  'log' => true,
  'banner' => 
  array (
    'template' => 'benrauto',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
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
    'lead_type_service' => false,
    'shown_cap' => false,
    'fillup_cap' => false,
    'session_close' => false,
    'device_type' => 
    array (
      'mobile' => false,
      'desktop' => false,
      'tablet' => false,
    ),
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
       '#002F6D',
       '#002F6D',
    ),
    'button_color_hover' => 
    array (
       '#003B89',
       '#003B89',
    ),
    'button_color_active' => 
    array (
       '#003B89',
       '#003B89',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Request virtual walk-around of your vehicle of interest',
    'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ben R Auto Team',
    'forward_to' => 
    array (
       'benrauto@gmail.com',
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
      'vdp' => '/\\/listings\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);