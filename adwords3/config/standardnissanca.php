<?php

global $CronConfigs;
$CronConfigs["standardnissanca"] = array(
    "name" => "standardnissanca",
    "email" => "regan@smedia.ca",
    "password" => "standardnissanca",
    "log" => true,
    'combined_feed_mode' => true,
    'customer_id' => '906-835-0952',
    'max_cost' => 150,
    'cost_distribution' => array(
        'adwords' => 150,
),
    "banner" => array(
        "template" => "standardnissanca",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
);