<?php
global $CronConfigs;
 $CronConfigs["maddigandodge"] = array( 
	"name"  =>" maddigandodge",
	"email" => "regan@smedia.ca", 'fb_brand'          => '[year] [make] [model] - [body_style]',
	"password" =>" maddigandodge",
	"log" => true ,
	
	"fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "maddigandodge",
			"fb_description" => "Are you still interested in this [year] [make] [model] [trim]? Click for more information! Stock: #[stock_number]. Sale price [price] + Applicable Taxes.",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model] [trim]. Click for more information! Stock: #[stock_number]. Sale price [price] + Applicable Taxes.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);