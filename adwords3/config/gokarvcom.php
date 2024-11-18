<?php

global $CronConfigs;
$CronConfigs["gokarvcom"] = array(
    "name" => "gokarvcom",
    "email" => "regan@smedia.ca",
    "password" => "gokarvcom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 2000,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 2000,
),
);