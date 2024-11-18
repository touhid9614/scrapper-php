<?php

global $CronConfigs;
$CronConfigs["cumberlandhondacom"] = array(
    'name'     => 'cumberlandhondacom',
    'email'    => 'regan@smedia.ca',
    'password' => 'cumberlandhondacom',
    'log'      => true,
    'customer_id' => '345-687-9011',
    'max_cost' => 125,
    'cost_distribution' => array(
        'adwords' => 125,
    ),
    'banner'   => array(
        'template'                 => 'cumberlandhondacom',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
);
