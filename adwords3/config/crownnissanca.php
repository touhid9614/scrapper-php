<?php

global $CronConfigs;
$CronConfigs["crownnissanca"] = array(
    "name" => " crownnissanca",
    "email" => "regan@smedia.ca",
    "password" => " crownnissanca",
    "log" => true,
    'max_cost' => 1400,
    'combined_feed_mode' => true,
    'cost_distribution' => array(
        'adwords' => 1200,
),
    "fb_new_title" => "[year] [make] [model] [msrp]",
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
    'customer_id' => '458-750-6676',
    "banner" => array(
        "template" => "crownnissanca",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //"fb_description" => "Finance this [year] [make] [model] from [biweekly] bi-weekly for 60 months. Click for more info!",
        //"fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_description_new" => "[year] [make] [model] [trim] - MSRP [msrp]. Lease at [lease] bi-weekly for 48 months. Call us at 204-269-1572.",		
        "fb_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly*. Call us at 204-269-1572.",
		"fb_dynamiclead_description_new" => "[year] [make] [model] [trim] - MSRP [msrp]. Lease at [lease] bi-weekly for 48 months. Click below and fill in your information. A product specialist will be in touch to answer any questions.",		
        "fb_dynamiclead_description_used" => "Buy this [year] [make] [model] [trim] for [price] or finance at [biweekly] bi-weekly*. Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);