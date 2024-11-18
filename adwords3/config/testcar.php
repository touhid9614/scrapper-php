<?php

global $CronConfigs;
$CronConfigs["testcar"] = array(
    "name" => " testcar",
    "email" => "regan@smedia.ca",
    "password" => " testcar",
    "no_adv" => true,
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => true,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#FFFFFF',
        'border_color' => '#FFFFFF',
        'button_color' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_hover' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_active' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '',
        'response_email' => '',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 0,
        'retarget_after' => 0,
        'fb_retarget_after' => 0,
        'adword_retarget_after' => 0,
        'visit_count' => 0,
),
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 200,
        'used' => 200,
),
);