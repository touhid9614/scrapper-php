<?php

global $CronConfigs;
$CronConfigs["mpyachtcentrecom"] = array(
    "name" => "mpyachtcentrecom",
    "email" => "regan@smedia.ca",
    "password" => "mpyachtcentrecom",
    "log" => true,
    'combined_feed_mode' => true,
    'max_cost' => 250,
    'cost_distribution' => array(
        'adwords' => 250,
),
"banner" => array(
        "template" => "mpyachtcentrecom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);