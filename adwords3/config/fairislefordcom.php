
<?php
global $CronConfigs;
$CronConfigs["fairislefordcom"] = array( 
	"name"  =>" fairislefordcom",
	"email" => "regan@smedia.ca",
	"password" =>" fairislefordcom",
	"log" => true,
	'combined_feed_mode' => true,
	
	  "banner" => array(
        "template" => "fairislefordcom",
			"fb_description" => "Are you still interested in the [year] [make] [model]?  It may not be available for long. Shop now!",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
);

