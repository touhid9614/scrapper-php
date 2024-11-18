<?php

global $CronConfigs;
$CronConfigs["crownmazdaca"] = array(
    "name" => " crownmazdaca",
    "email" => "regan@smedia.ca",
    "password" => " crownmazdaca",
    "customer_id" => "942-245-3454",
    "log" => true,
    'model_map' => [
        'Mazda' => [
            '3' => 'Mazda3',
            '3 Sport' => 'Mazda3 Sport',
            '6' => 'Mazda6',
],
],
    "banner" => array(
        "template" => "crownmazdaca",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_description" => "Finance this [year] [make] [model] from [biweekly] bi-weekly for 60 months. Click for more info!",
        //"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "fb_description_new" => "[year] [make] [model] [trim] - MSRP [msrp]. Lease at [biweekly] bi-weekly for 48 months. Call us at 204-885-2623.",
        "fb_alt_description_new" => "[year] [make] [model] [trim] - MSRP [msrp]. Call us at 204-885-2623.",
        "fb_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly for 60 months! Call us at 204-885-2623.",
        "fb_alt_description_used" => "Buy this [year] [make] [model] [trim] for [price]. Call us at 204-885-2623.",
        "g_description_new" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "g_description_used" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_dynamiclead_description_new" => "[year] [make] [model] [trim] - MSRP [msrp]. Lease at [biweekly] bi-weekly for 48 months. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
		"fb_dynamiclead_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly for 60 months! Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 800,
),
);