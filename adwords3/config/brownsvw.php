<?php

global $CronConfigs;

$CronConfigs["brownsvw"] = array (
  'name' => 'brownsvw',
  'email' => 'regan@smedia.ca',
  'password' => 'brownsvw',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'brownsvw',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
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
       '#00ADEB',
       '#00ADEB',
    ),
    'button_color_hover' => 
    array (
       '#004A98',
       '#004A98',
    ),
    'button_color_active' => 
    array (
       '#004A98',
       '#004A98',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '4 Year Prepaid Maintenance at Browns Volkswagen',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Browns Volkswagen Team',
    'forward_to' => 
    array (
       'richard@brownsvw.ca',
       'david@brownsvw.ca',
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
      'vdp' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);