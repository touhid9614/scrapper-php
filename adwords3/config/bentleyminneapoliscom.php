<?php

global $CronConfigs;

$CronConfigs["bentleyminneapoliscom"] = array (
  'name' => 'bentleyminneapoliscom',
  'email' => 'regan@smedia.ca',
  'password' => 'bentleyminneapoliscom',
  'log' => true,
  'combined_feed_mode' => true,
    "fb_new_title" => "New [year] [make] [model] [price]",
    "fb_used_title" => "Pre-Owned [year] [make] [model] [price]",
    "fb_certified_title" => "Certified Pre-Owned [year] [make] [model] [price]",
    'banner' => 
  array (
    'template' => 'bentleyminneapoliscom',
    'fb_description_new' => 'Are you still interested in the New [year] [make] [model]? Click for more info!',
        'fb_description_used' => 'Are you still interested in the Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_description_certified' => 'Are you still interested in the Certified Pre-Owned [year] [make] [model]? Click for more info!',
        'fb_lookalike_description_new' => 'Check out this New [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_used' => 'Check out this Pre-Owned [year] [make] [model] today. Click for more information.',
        'fb_lookalike_description_certified' => 'Check out this Certified Pre-Owned [year] [make] [model] today. Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
 //   'fb_style' => 'facebook_new_ad',
  ),
);