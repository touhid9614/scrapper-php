<?php

global $CronConfigs;

$CronConfigs["hgregoire"] = array(
  //'budget'    => 2.0,
  'bid'           => 3.0,
  'password'  => 'hgregoire.php',
    'post_code'     => 'N8M 2C8',
  

    "email"         => "regan@smedia.ca",
    "banner"        => array(
        "template"          => "hgregoire.php",
			"flash_style"       => "default",
			"hst" => yes,
                        "hst_l1" => "+GST",
                        "hst_l2" => "&LIC",
			"border_color"    => "#282828",
        "styels"            => array(
            "new_display"   => "custom_banner",
            "used_display"  => "custom_banner",
            "new_retargeting"  => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers"   => "custom_banner",
            "used_marketbuyers"  => "custom_banner"
            ),
        "font_color"        => "#ffffff"
        ),
       
    );
