<?php

global $CronConfigs;

$CronConfigs["competitionchev"] = array (
  'name' => 'competitionchev',
  'password' => 'competitionchev',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'max_cost' => 900,
  'cost_distribution' => 
  array (
    'adwords' => 900,
  ),
  'lead' => 
  array (
    'live' => false,
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
       '#6EB43B',
       '#508622',
    ),
    'button_color_hover' => 
    array (
       '#599230',
       '#508622',
    ),
    'button_color_active' => 
    array (
       '#891C1D',
       '#891C1D',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$250 credit towards dealership accessory purchases from Competition Chevrolet with vehicle purchase',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Competition Chevrolet Team',
    'forward_to' => 
    array (
       'chiggins@competitionchev.com',
       'jprodrutti@competitionchev.com',
       'pstanton@competitionchev.com',
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
      'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
      'service_regex' => '',
    ),
  ),
  'create' => 
  array (
  	"used_search" => yes,
  	"new_search" => yes,
  ),
  'new_descs' => 
  array (
     
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
     
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
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
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'banner' => 
  array (
    'template' => 'competitionchev',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
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
);
