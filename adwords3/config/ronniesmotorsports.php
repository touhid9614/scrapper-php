<?php
global $CronConfigs;
 $CronConfigs["ronniesmotorsports"] = array( 
	"name"  =>" ronniesmotorsports",
	"email" => "regan@smedia.ca",
	"password" =>" ronniesmotorsports",
	"log" => true ,
	"banner" => array(
        "template" => "ronniesmotorsports",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more info.",
        'fb_lookalike_description' => "Test drive the [year] [make] [model] today.",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
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