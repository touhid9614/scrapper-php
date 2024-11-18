<?php
global $CronConfigs;
$CronConfigs["machaikdcjcom"] = array( 
	"name"  =>"machaikdcjcom",
	"email" => "regan@smedia.ca",
	"password" =>"machaikdcjcom",
	"log" => true,
	'combined_feed_mode' => true,
        "banner" => array(
        "template" => "machaikdcjcom",
        "fb_marketplace_title" => "[year] [make] [model] [trim] - [stock_number]",    
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

