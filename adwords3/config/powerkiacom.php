<?php

global $CronConfigs;
$CronConfigs["powerkiacom"] = array(
    "name" => " powerkiacom",
    "email" => "regan@smedia.ca",
    "password" => " powerkiacom",
    "log" => true,
    "customer_id" => "819-231-3656",
    'max_cost' => 0.01,
    'cost_distribution' => array(
        'adwords' => 0.01,
    ),
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "powerkiacom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

