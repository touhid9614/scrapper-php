<?php

global $CronConfigs;

$CronConfigs["champaignchryslerdodgejeep"] = array (
  'name' => 'champaignchryslerdodgejeep',
  'email' => 'regan@smedia.ca',
  'password' => 'champaignchryslerdodgejeep',
  'log' => true,
  'banner' => 
  array (
    'template' => 'champaignchryslerdodgejeep',
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
       '#BF0E0E',
       '#BF0E0E',
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
    'button_text_color' => '#ffffff',
    'response_email_subject' => '$200 off coupon from Champaign Chrysler Dodge Jeep Ram',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Champaign CDJR Team',
    'forward_to' => 
    array (
       'dealership@dealership.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/(?:new|used)-[^-]+-[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'adf_to' => 
  array (
  ),
  'form_live' => false,
  'buttons_live' => false,
);