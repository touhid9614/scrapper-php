<?php

global $CronConfigs;
$CronConfigs["crowntoyotaca"] = array(
    "name" => " crowntoyotaca",
    "email" => "regan@smedia.ca",
    "password" => " crowntoyotaca",
    "customer_id" => "371-440-3809",
    'max_cost' => 2500,
    'cost_distribution' => array(
        'adwords' => 2500,
),
    "fb_new_title" => "[year] [make] [model] [msrp]",
    "log" => true,
    "banner" => array(
        "template" => "crowntoyotaca",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_description_new" => "[year] [make] [model] - MSRP [msrp]. Lease at [biweekly] bi-weekly for 48 months.",
        "fb_alt_description_new" => "[year] [make] [model] - MSRP [msrp].",
        "fb_description_used" => "Buy this [year] [make] [model] for [price] or finance at [biweekly] bi-weekly*.",
        "fb_alt_description_used" => "Buy this [year] [make] [model] for [price].",
        //"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description_new" => "[year] [make] [model] - MSRP [msrp]. Lease at [biweekly] bi-weekly for 48 months. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "fb_dynamiclead_description_used" => "Buy this [year] [make] [model] for [price] or finance at [biweekly] bi-weekly*. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);