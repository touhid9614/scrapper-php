<?php

global $CronConfigs;

$CronConfigs["carriagekiawoodstock"] = array (
  'name' => 'carriagekiawoodstock',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'email' => 'regan@smedia.ca',
  'password' => 'carriagekiawoodstock',
  'customer_id' => '175-014-2242',
  'log' => true,
  'max_cost' => 4200,
  'cost_distribution' => 
  array (
    'adwords' => 4200,
  ),
  'banner' => 
  array (
    'template' => 'carriagekiawoodstock',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
      'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'mail_retargeting' => 
  array (
    'enabled' => true,
    'client_id' => '17944',
    'promotion_text' => 'Call Us Today! 678.717.4012',
    'promotion_color' => '#C32032',
    'overlay_color' => '#C32032',
    'overlay_text_colour' => '#FFFFFF',
    'price_color' => '#C32032',
    'coupon_validity' => '30',
  ),
);