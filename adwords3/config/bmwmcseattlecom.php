<?php

global $CronConfigs;

$CronConfigs["bmwmcseattlecom"] = array (
  'name' => 'bmwmcseattlecom',
  'email' => 'regan@smedia.ca',
  'password' => 'bmwmcseattlecom',
  'log' => true,
     'combined_feed_mode' => true,
  'customer_id' => '198-780-4246',
  'max_cost' => 2000,
    'cost_distribution' => array(
       'adwords' => 2000,
    ),
  "banner" => array(
        "template" => "bmwmcseattlecom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);