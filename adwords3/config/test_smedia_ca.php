<?php

global $CronConfigs;
$CronConfigs["test_smedia_ca"] = array(
    "name"               => "test_smedia_ca",
    "email"              => "zaber.mahbub@smedia.ca",
    "password"           => "test_smedia_ca",
    "log"                => true,
    "combined_feed_mode" => true,
    'banner'             => array(
        'template'                   => 'test_smedia_ca',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
        'fb_aia_description'         => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
        
    ),
);
