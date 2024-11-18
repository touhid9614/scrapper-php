<?php

global $CronConfigs;

$CronConfigs["fourseasonssales"] = 
[
    "name" => " fourseasonssales",
    "email" => "regan@smedia.ca",
    "password" => " fourseasonssales",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    
    "banner" => 
    [
        "template" => "fourseasonssales",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ],

    'cities' => 
    [
        'Virden' => 
        [
            'address' => 'Box 968 Trans-Canada Highway No 1',
            'city' => 'Virden',
            'state' => 'Manitoba',
            'country_name' => 'Canada',
            'post_code' => 'R0M 2C0',
            'full_address' => 'Box 968 Trans-Canada Highway No 1, Virden, Manitoba MB R0M 2C0',
            'phone' => '1-888-934-4444',
            'lat' => '49.879290',
            'lng' => '-100.981490'
        ],
        'Winnipeg' => 
        [
            'address' => '5130 Portage Avenue',
            'city' => 'Winnipeg',
            'state' => 'Manitoba',
            'country_name' => 'Canada',
            'post_code' => 'R4H 1E1',
            'full_address' => '5130 Portage Avenue, Headingley, Winnipeg, MB, R4H 1E1',
            'phone' => '1-204-895-8882',
            'lat' => '49.875180',
            'lng' => '-97.394350'
        ],
        'Regina' => 
        [
            'address' => 'Hwy 1 and 6',
            'city' => 'Regina',
            'state' => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code' => 'S4P 5A8',
            'full_address' => 'Hwy 1 and 6, Regina, SK, S4P 5A8',
            'phone' => '1-877-789-3311',
            'lat' => '50.407970',
            'lng' => '-104.589690'
        ]
    ]
];