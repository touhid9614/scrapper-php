<?php
global $CronConfigs;
 $CronConfigs["morriesmazda"] = array(
    "name" => " morriesmazda",
    "email" => "regan@smedia.ca",
    //'fb_brand' => '[year] [MAKE][MODEL] ',
    //https://app.asana.com/0/0/1197080555062892/f
     "fb_new_title" => "New [year] [make] [model] [price]",
    "fb_used_title" => "Pre-Owned [year] [make] [model] [price]",
    "fb_certified_title" => "Certified Pre-Owned [year] [make] [model] [price]",
    "password" => " morriesmazda",
    "log" => true,
    'max_cost' => .01,
    'cost_distribution' => array(
        'adwords' => .01,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
    ),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    'customer_id' => '919-369-7021',
    
    //=====dynamic social ads=====
    "banner" => array(
         'fb_banner_title'          => '[title]',
        "template" => "morriesmazda",
       // 'fb_banner_title'          => '[year] [make][model]',
        "fb_title_new_3"               => "New [year] [make][model] [price]",
        "fb_title_used_3"               => "Pre-Owned [year] [make][model] [price]",
        "fb_title_certified_3"               => "Certified Pre-Owned [year] [make][model] [price]",
        "fb_title_new_6"               => "New [year] [make][model] [price]",
        "fb_title_used_6"               => "Pre-Owned [year] [make][model] [price]",
        "fb_title_certified_6"               => "Certified Pre-Owned [year] [make][model] [price]",
        
        'fb_description_new' => 'Are you still interested in the New [year] [make] [model]?  Click for more info!',
        'fb_description_used' => 'Are you still interested in the Pre-Owned [year] [make] [model]?  Click for more info!',
        'fb_description_certified' => 'Are you still interested in the Certified Pre-Owned [year] [make] [model]?  Click for more info!',
        
       
        "fb_description_new_3"         => "Are you still interested in the New [year] [make][model]?  Click for more information.",
        "fb_description_used_3"         => "Are you still interested in the Pre-Owned [year] [make][model]?  Click for more information.",
        "fb_description_certified_3"         => "Are you still interested in the Certified Pre-Owned [year] [make][model]?  Click for more information.",
        
        "fb_description_new_6"         => "Are you still interested in the New [year] [make][model]?  Click for more information.",
        "fb_description_used_6"         => "Are you still interested in the Pre-Owned [year] [make][model]?  Click for more information.",
        "fb_description_certified_6"         => "Are you still interested in the Certified Pre-Owned [year] [make][model]?  Click for more information.",
        
        "fb_lookalike_description_new" => "Check out this New [year] [make] [model] today!  Click for more information.",
        "fb_lookalike_description_used" => "Check out this Pre-Owned [year] [make] [model] today!  Click for more information.",
        "fb_lookalike_description_certified" => "Check out this Certified Pre-Owned [year] [make] [model] today!  Click for more information.",
        
        "fb_lookalike_description_new_3" => "Check out this New [year] [make][model] today!  Click for more information.",
        "fb_lookalike_description_used_3" => "Check out this Pre-Owned [year] [make][model] today!  Click for more information.",
        "fb_lookalike_description_certified_3" => "Check out this Certified Pre-Owned [year] [make][model] today!  Click for more information.",
        
        "fb_lookalike_description_new_6" => "Check out this New [year] [make][model] today!  Click for more information.",
        "fb_lookalike_description_used_6" => "Check out this Pre-Owned [year] [make][model] today!  Click for more information.",
        "fb_lookalike_description_certified_6" => "Check out this Certified Pre-Owned [year] [make][model] today!  Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
		"fb_style" => "morries",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner"
        ),
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
);
