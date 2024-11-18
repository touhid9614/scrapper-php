<?php

global $CronConfigs;

$CronConfigs["macdonaldautogroup"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'password' => 'macdonaldautogroup',
    'post_code' => 'N8M 2C8',
    'log' => true,
    "email" => "regan@smedia.ca",
    "banner" => array(
        "template" => "macdonaldautogroup",
        "flash_style" => "default",
        "hst" => yes,
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner"
        ),
        "font_color" => "#ffffff"
    ),
);
