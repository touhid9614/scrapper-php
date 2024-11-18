<?php
global $CronConfigs;
 $CronConfigs["budgetcarsales"] = array( 
	"name"  =>" budgetcarsales",
	"email" => "regan@smedia.ca",
	"password" =>" budgetcarsales",
	"log" => true ,
        'customer_id' => '987-348-7337',
        'max_cost' => 1165,
        'cost_distribution' => array(
            'adwords' => 1165,
        ),
	"banner" => array(
        "template" => "budgetcarsales",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

