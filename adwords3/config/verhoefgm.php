<?php

global $CronConfigs;
$CronConfigs["verhoefgm"] = array(
    'password' => 'verhoefgm',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "verhoefgm",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17613',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);