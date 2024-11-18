<?php
global $CronConfigs;
 $CronConfigs["allamericanharley"] = array( 
	"name"  =>" allamericanharley",
	"email" => "regan@smedia.ca",
	"password" =>" allamericanharley",
	"log" => true ,
	 "banner" => array(
        "template" => "allamericanharley",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more info.",
        'fb_lookalike_description' => "Test drive the [year] [make] [model] today.",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            //"used_display"  => "quick_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            //"used_retargeting" => "quick_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
        ),
        "font_color" => "#ffffff",
    ),
);