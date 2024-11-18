<?php

global $CronConfigs;

$CronConfigs["tomballford"] = array(
  'password'  => 'tomballford',
    "email"         => "regan@smedia.ca",
    'log'           => true,
    'tag_debug'     => false,
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    "banner"        => array(
        "template"          => "tomballford",
        'fb_description'    => 'Are you still interested in the [Year] [Make] [Model]? Click here to see our new price!',
        'fb_lookalike_description'	=> 'Test drive the [year] [make] [model] today!',
        "flash_style"       => "default",
        "border_color"    => "#282828",
        "font_color"        => "#ffffff"
    ),
);

add_filter('filter_tomballford_fb_description', 'filter_tomballford_fb_description', 10, 3);

function filter_tomballford_fb_description($description, $car, $feed_type) {
    if($feed_type == 'lookalike' && isset($car['msrp']) && $car['msrp']) {
        $description .= " MSRP " . butifyPrice($car['msrp']) . " Now " . butifyPrice($car['price']) . "!";
    }
    return $description;
}
