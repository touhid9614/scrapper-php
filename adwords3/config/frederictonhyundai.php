<?php

global $CronConfigs;

$CronConfigs["frederictonhyundai"] = array (
  'name' => 'frederictonhyundai',
  'email' => 'regan@smedia.ca',
  'password' => 'frederictonhyundai',
  'log' => true,
  'banner' => 
  array (
    'template' => 'frederictonhyundai',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
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
       '#06336C',
       '#06336C',
    ),
    'button_color_hover' => 
    array (
       '#000000',
       '#000000',
    ),
    'button_color_active' => 
    array (
       '#000000',
       '#000000',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Get $200 off coupon from Fredericton Hyundai',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fredericton Hyundai Team',
    'forward_to' => 
    array (
       'jmcintyre@steeleauto.com',
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
      'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);