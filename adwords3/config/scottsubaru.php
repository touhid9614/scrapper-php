<?php

global $CronConfigs;
$CronConfigs["scottsubaru"] = array(
    "name" => "scottsubaru",
    "email" => "regan@smedia.ca",
    "password" => "scottsubaru", 'fb_brand'          => '[year] [make] [model] - [body_style]',
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Contact us today!',
        "fb_lookalike_description"  => "[year] [make] [model] - Contact us today!",
        "template" => "scottsubaru",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);
