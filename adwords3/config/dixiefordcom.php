<?php

global $CronConfigs;
$CronConfigs["dixiefordcom"] = array(
    "name"     => "dixiefordcom",
    "email"    => "regan@smedia.ca",
    "password" => "dixiefordcom",
    "log"      => true,
    "banner"   => array(
        'template'                   => 'dixiefordcom',
        'fb_description'             => '[description]',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information. Price does not include HST and licensing.',
        "fb_marketplace_description" => "Are you still interested in the [year] [make] [model]? Click for more information. Price does not include HST and licensing. Disclaimer: [disclaimer]",
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
        "hst"                        => yes
    ),
);