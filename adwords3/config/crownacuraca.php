<?php

global $CronConfigs;
$CronConfigs["crownacuraca"] = array(
    "name" => " crownacuraca",
    "email" => "regan@smedia.ca",
    "password" => " crownacuraca",
    "log" => true,
    'max_cost' => 1075,
    'cost_distribution' => array(
        'adwords' => 1075,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '152-616-2552',
    "banner" => array(
        "template" => "crownacuraca",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_description_new" => "Buy this [year] [make] [model] [trim] for [price]. ",
        //"fb_description_2020_rdx" => "Buy this [year] [make] [model] for [price]. $2000 customer cash rebate on most models. Finance/lease rate as low as 0%. ",
        //"fb_description_2020_mdx" => "Buy this [year] [make] [model] for [price]. $7500 customer cash rebate on most models. Finance/lease rate as low as 0%. ",
        //"fb_description_2020_tlx" => "Buy this [year] [make] [model] for [price]. $4500 customer cash rebate on most models. Finance/lease rate as low as 0%. ",
        //"fb_description_2020_ilx" => "Buy this [year] [make] [model] for [price]. Up to $2000 customer cash rebate on most models. Finance rates at 1.49% lease rates 0%. ",
        "fb_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly for 60 months! ",
		"fb_dynamiclead_description_new" => "Buy this [year] [make] [model] [trim] for [price]. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
		"fb_dynamiclead_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly for 60 months! Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);