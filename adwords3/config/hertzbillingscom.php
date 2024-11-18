<?php

global $CronConfigs;
$CronConfigs["hertzbillingscom"] = array(
    "name" => " hertzbillingscom",
    "email" => "regan@smedia.ca",
    "password" => " hertzbillingscom",
    "log" => true,
    'customer_id' => '707-296-6470',
    "banner" => array(
        "template" => "hertzbillingscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1300,
    'cost_distribution' => array(
        'new' => 700,
        'used' => 600,
),
);