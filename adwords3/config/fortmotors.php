<?php

global $CronConfigs;

$CronConfigs["fortmotors"] = array (
  'name' => 'fortmotors',
  'email' => 'regan@smedia.ca',
  'password' => 'fortmotors',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'fortmotors',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
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
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
       '#1488C3',
       '#1488C3',
    ),
    'button_color_hover' => 
    array (
       '#1D4580',
       '#1D4580',
    ),
    'button_color_active' => 
    array (
       '#1D4580',
       '#1D4580',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$250 offer from Fort Motors',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fort Motors Team',
    'forward_to' => 
    array (
       'mshant1@fortmotors.ca',
       'alanbourdon1@outlook.com',
       'ctymchuk@fortmotors.ca',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'lead_to' => 
  array (
     'mshant1@fortmotors.ca',
     'alanbourdon1@outlook.com',
     'ctymchuk@fortmotors.ca',
  ),
  'form_live' => false,
  'buttons_live' => false,
);