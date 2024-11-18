<?php

global $CronConfigs;
$CronConfigs["peheartlandhonda_powerdealer_honda"] = array(
    "name" => " peheartlandhonda_powerdealer_honda",
    "email" => "regan@smedia.ca",
    "password" => " peheartlandhonda_powerdealer_honda",
    'log' => true,
    'bing_account_id' => 156003273,
    "customer_id" => "302-970-7629",
    'max_cost' => 30.0,
    'cost_distribution' => array(
        'adwords' => 30,
    ),
    "create" => array(
        "new_display" => yes,
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
    "banner" => array(
        "template" => "peheartlandhonda_powerdealer_honda",
        "fb_description" => "Are you still interested in the [make] [model]? Click to get your best deal!",      
       // "fb_description" => "Are you still interested in the [year] [make] [model]? Click to get your best deal!",      
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
           "styels" => array(
            "new_display" => "dynamic_banner", 
        ),
    ),
);
