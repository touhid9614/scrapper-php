<?php

global $CronConfigs;

$CronConfigs["autoparkbarrie"] = array (
  'password' => 'autoparkbarrie',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'banner' => 
  array (
    'template' => 'autoparkbarrie',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => false,
    'lead_type_used' => true,
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
       '#F79323',
       '#F79323',
    ),
    'button_color_hover' => 
    array (
       '#034C9C',
       '#034C9C',
    ),
    'button_color_active' => 
    array (
       '#034C9C',
       '#034C9C',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$150 off coupon from Humberview AutoPark Barrie',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Humberview AutoPark Barrie Team',
    'forward_to' => 
    array (
       'sales_barrie@autopark.ca',
       'leads@autopark.ca',
       'paul_cosentino@autopark.ca',
       'shawn_miller@autopark.ca',
       'mpoliakov@humberviewgroup.com',
       'skhurana@humberviewgroup.com',
       'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
       'leads@autopark.ca',
    ),
    'special_email' => '',
    'display_after' => 30000,
    'retarget_after' => 5000,
    'fb_retarget_after' => 5000,
    'adword_retarget_after' => 5000,
    'visit_count' => 0,
    'lead_in' => 
    array (
      'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'form_live' => false,
  'buttons_live' => false,
  'name' => 'autoparkbarrie',
);