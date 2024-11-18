<?php

global $CronConfigs;

$CronConfigs["southsidechev"] = array (
  'name' => 'southsidechev',
  'email' => 'regan@smedia.ca',
  'password' => 'southsidechev',
  'log' => true,
  'customer_id' => '579-288-1433',
  'max_cost' => 500,
  'cost_distribution' => 
  array (
    'new' => 500,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'banner' => 
  array (
    'template' => 'southsidechev',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'fb_agedstock_description' => 'Get financed at 0% on remaining in-stock 2019 inventory! Until March 17th only! ',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_combined' => 'dynamic_banner_noprice',
      'used_combined' => 'dynamic_banner',
      'new_display' => 'dynamic_banner_noprice',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner_noprice',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner_noprice',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => 'ffffff',
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
      0 => '#CC0033',
      1 => '#CC0033',
    ),
    'button_color_hover' => 
    array (
      0 => '#990026',
      1 => '#990026',
    ),
    'button_color_active' => 
    array (
      0 => '#990026',
      1 => '#990026',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off coupon from Southside Chevrolet Buick GMC',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Southside Chevrolet Buick GMC Team',
    'forward_to' => 
    array (
      0 => 'denis@southsidechev.com',
      1 => 'bwells@southsidechev.com',
      2 => 'marshal@smedia.ca',
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
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
      'service_regex' => '',
    ),
  ),
);