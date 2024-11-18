<?php

global $CronConfigs;
$CronConfigs["ridetime"] = array(
    "name" => " ridetime",
    "email" => "regan@smedia.ca",
    "password" => " ridetime",
    "log" => true,
    'max_cost' => 0,
    'cost_distribution' => array(),
    "customer_id" => "268-443-9493",
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
);