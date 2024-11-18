<?php
global $CronConfigs;
$CronConfigs["northernhondacom"] = array( 
	"name"  => "northernhondacom",
	"email" => "regan@smedia.ca",
	"password" => "northernhondacom",
	"log" => true,
        'customer_id' => '867-660-4950',
        'combined_feed_mode' => true,
        'max_cost' => 2525,
        'cost_distribution' => array(
        'adwords' => 2525,
        ),
        "create" => array(
            "new_search" => yes,
            "used_search" => no,
        
    ),
    'new_title' => "[year(2)] [make(1)] [model]",
        "new_descs" => array(
                array(
                    "title2" => "Schedule a Test Drive",
                    "title3" => "See Inventory, Photos & Price",
                    "description" => "Check Out Our [Year] [Make] [Model].",
                    "description2" => "Lease from [lease] Monthly + HST. Offer Ends Soon",
        ),
                array(
                    "title2" => "Lease from [lease] Monthly",
                    "title3" => "Limited Time Special Offer",
                    "description" => "Get the [Year] [Make] [Model].",
                    "description2" => "See Inventory, Specs & Price. Schedule a Test Drive",
        ),
              
        ),
        "banner" => array(
        "template" => "northernhondacom",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
        "fb_new_title" => "[year] [make] [model] [lease] + HST monthly",
);

