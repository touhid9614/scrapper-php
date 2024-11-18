<?php
global $CronConfigs;
 $CronConfigs["brantfordhonda"] = array( 
	"name"  =>" brantfordhonda",
	"email" => "regan@smedia.ca",
	"password" =>" brantfordhonda",
	"log" => true ,
	"fb_title" => "[year] [make] [model] [price]",
     'fb_brand'          => '[year] [make] [model] - [body_style]',
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "brantfordhonda",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner"
        ),
    ),
);