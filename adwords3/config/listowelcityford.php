<?php

global $CronConfigs;

$CronConfigs["listowelcityford"] = array(
  //'budget'    => 2.0,
  'bid'           => 3.0,
  'password'  => 'listowelcityford',
  'post_code'     => 'N4W 1L8',
  'log'           => true,
  "email"         => "regan@smedia.ca",
  "banner"        => array(
  "template"          => "listowelcityford",
  'fb_description_new'	=> 'Are you still interested in the [year] [make] [model]? Click below for more info!',
  'fb_description_used'	=> 'Test Drive the [year] [make] [model] today!',
  "flash_style"       => "default",
  "hst" => yes,
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

