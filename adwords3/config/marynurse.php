<?php

global $CronConfigs;

$CronConfigs["marynurse"]       =  array(
    'password'                  => 'marynurse',
    "email"                     => "regan@smedia.ca",
    'log'                       => true,
    //Client wants trim level included in Facebook Ads
    //https://app.asana.com/0/1159366839112632/1191979893163483
	"fb_title" => "[year] [make] [model] [trim]",
    "banner"                    => array(
        "template"              => "marynurse",
		'fb_description_new'        => 'Are you still interested in the new [year] [make] [model]? Cash purchase price [price]! Offer ends October 31st.',
		'fb_description_used'       => 'Are you still interested in this pre-owned [year] [make] [model]? Cash purchase price [price]! Schedule your virtual appointment today.',
		'fb_description_certified'  => 'Are you still interested in this certified pre-owned [year] [make] [model]? Cash purchase price [price]! Schedule your virtual appointment today.',
		'fb_lookalike_description_new'        => 'Check out this new [year] [make] [model] today. Cash purchase price [price]! Offer ends October 31st.',
		'fb_lookalike_description_used'       => 'Check out this pre-owned [year] [make] [model] today. Cash purchase price [price]! Schedule your virtual appointment today.',
		'fb_lookalike_description_certified'  => 'Check out this certified pre-owned [year] [make] [model] today. Cash purchase price [price]! Schedule your virtual appointment today.',
		//'fb_description'        => 'Are you still interested in the [year] [make] [model]? Don\'t pay for 90 days when you finance (OAC) a new or pre-owned in-stock vehicle. Offer expires January 31, 2019. Visit www.marynurse.com/90-Days for details.',		
        "flash_style"           => "default",
        "hst"                   => yes,
        "border_color"          => "#282828",
        "font_color"            => "#ffffff",
    
    )
);
