<?php

global $CronConfigs;
$CronConfigs["openroadoutletca"] = array(
    'name' => 'openroadoutletca',
    'email' => 'regan@smedia.ca',
    'password' => 'openroadoutletca',
    'log' => true,
    'cities' => array(
        'steinbach' => array(
            'address' => '301 Provinicial Truck Highway 12',
            'city' => 'Steinbach',
            'state' => 'Manitoba',
            'country_name' => 'Canada',
            'post_code' => 'R5G 1P8',
            'full_address' => '301 Provincial Trunk Hwy 12N, Steinbach, MB R5G 1T8, Canada',
            'phone' => '1-204-326-3344',
            'lat' => '49.527721',
            'lng' => '-96.690552',
),
        'winnipeg' => array(
            'address' => '33 Emes Road',
            'city' => 'Winnipeg',
            'state' => 'Manitoba',
            'country_name' => 'Canada',
            'post_code' => 'R2P 2V9',
            'full_address' => '33 Emes Rd, West Saint Paul, Winnipeg,  MB R2P 2V9, Canada',
            'phone' => '1-204-338-8625',
            'lat' => '49.895138',
            'lng' => '-97.138374',
),
),
    "banner" => array(
        "template" => "openroadoutletca",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 2400,
    'cost_distribution' => array(
        'new' => 1200,
        'used' => 1200,
),
);