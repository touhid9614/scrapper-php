<?php

global $CronConfigs;
$CronConfigs["winnipeghondaca"] = array(
    "name" => " winnipeghondaca",
    "email" => "regan@smedia.ca",
    "password" => " winnipeghondaca",
    "customer_id" => "708-908-4044",
    "log" => true,
    "banner" => array(
        "template" => "winnipeghondaca",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_description" => "Finance this [year] [make] [model] from [biweekly] bi-weekly for 60 months. Click for more info!",
        //"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        //////   "fb_description_new" => "[year] [make] [model] - [price]. Lease at [lease] bi-weekly for 48 months. Call us at 204-261-9580.",
        "fb_description_new" => "[year] [make] [model] - [price]. Lease at [biweekly] bi-weekly for 48 months.",
        "fb_alt_description_new" => "[year] [make] [model] - Price [price].",       
        "fb_description_used" => "Buy this [year] [make] [model] for [price] or finance at [biweekly] bi-weekly*.",
        "fb_alt_description_used" => "Buy this [year] [make] [model] for [price].",
		"fb_dynamiclead_description_new" => "[year] [make] [model] - [price]. Lease at [biweekly] bi-weekly for 48 months. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
		"fb_dynamiclead_description_used" => "Buy this [year] [make] [model] for [price] or finance at [biweekly] bi-weekly*. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1580,
    'cost_distribution' => array(
        'adwords' => 1580,
),
);