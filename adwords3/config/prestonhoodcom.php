<?php
global $CronConfigs;
$CronConfigs["prestonhoodcom"] = array( 
	"name"  => "prestonhoodcom",
	"email" => "regan@smedia.ca",
	"password" => "prestonhoodcom",
        'customer_id' => '224-503-3798',
	"log" =>true,
	"combined_feed_mode" => true,
        'max_cost' => 0.01,
        'cost_distribution' => [
            'adwords' => 0.01,
        ],
);

