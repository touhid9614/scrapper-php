<?php

global $CronConfigs;

$CronConfigs["meritfordcom"] = array (
  'name' => 'meritfordcom',
  'email' => 'regan@smedia.ca',
  'password' => 'meritfordcom',
  'log' => true,
  'customer_id' => '510-347-7054',
  'combined_feed_mode' => true,
  'max_cost' => 200,
  'cost_distribution' => 
  array (
    'adwords' => 200,
  ),
  'banner' => 
  array (
    'template' => 'meritfordcom',
      'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Merit Ford Sales offers many automotive products and services to our Carlyle area customers - from quality new Ford vehicles to used cars. Shop now!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Merit Ford Sales offers many automotive products and services to our Carlyle area customers - from quality new Ford vehicles to used cars. Shop now!',
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
      0 => '#0678BC',
      1 => '#0678BC',
    ),
    'button_color_hover' => 
    array (
      0 => '#0D2F4D',
      1 => '#0D2F4D',
    ),
    'button_color_active' => 
    array (
      0 => '#0D2F4D',
      1 => '#0D2F4D',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'We Buy Your Car - Same Day $$ Quick and Easy!',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Merit Ford Team',
    'forward_to' => 
    array (
      0 => 'marshal@smedia.ca',
      1 => 'sales@meritford.com',
    ),
    'special_to' => 
    array (
      0 => '',
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
      'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);