<?php

global $CronConfigs;
$CronConfigs["nextgenautoca"] = array(
        "name" => "nextgenautoca",
         "email" => "regan@smedia.ca",
         "password" => "nextgenautoca",
         "log" => true,
         'max_cost' => 600,
         'cost_distribution' => array(
        'adwords' => 600,
         ),
         "customer_id" => "510-647-9639",
         "create" => array(
                "new_search" => no,
                 "used_search" => no,
                 "new_display" => no,
                 "used_display" => no,
                 "new_retargeting" => no,
                 "used_retargeting" => no,
                 "new_marketbuyers" => no,
                 "used_marketbuyers" => no,
                 "new_combined" => no,
                 "used_combined" => no,
                 "new_placement" => no,
                 "used_placement" => no,
         ),
         "new_descs" => array(
                array(
                "desc1" => "Test Drive the [year]",
                 "desc2" => "[make] [model] today.",
                 ),
                 array(
                "desc1" => "Call us today about the ",
                 "desc2" => "[year] [make] [model]",
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
         
         "banner" => array(
            "template" => "nextgenautoca",
            "flash_style" => "default",
             "styels" => array(
                    "new_display" => "dynamic_banner",
                     "used_display" => "dynamic_banner",
                     "new_retargeting" => "dynamic_banner",
                     "used_retargeting" => "dynamic_banner",
                     "new_marketbuyers" => "dynamic_banner",
                     "used_marketbuyers" => "dynamic_banner",   
             ),
        ),     
);

