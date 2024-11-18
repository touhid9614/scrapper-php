<?php

require_once 'includes/loader.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $connection, $BannerConfigs, $user, $dont_do_anything;

$cron_name   = $user['cron_name'];
$cron_config = $user['cron_config'];

$tabs = [];

$stock_types = array('new', 'used', 'certified', 'device', 'accessory');
$directives  = array('display', 'retargeting', 'marketbuyers', 'combined');

foreach ($directives as $directive) {
    foreach ($stock_types as $stock_type) {
        $key = $stock_type . '_' . $directive;

        if (isset($cron_config['create'][$key]) && $cron_config['create'][$key] == yes) {
            $tabs[$stock_type . $directive] = array(
                'stock_type'  => $stock_type,
                'directive'   => $directive,
                't_directive' => $directive,
            );

            if ($directive == 'combined') {
                $tabs[$stock_type . $directive]['t_directive'] = 'display';
            }

        }
    }
}

$mutex = Mutex::create();

$db_connect = new DbConnect($cron_name);

$cars_db     = [];
$ads_db      = [];
$all_cars_db = [];

$db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);

$good_car    = null;
$medium_car  = null;
$worst_car   = null;
$ignore      = false;
$style_found = false;

foreach ($all_cars_db as $car) {
    $stock_type = $car['stock_type'];
    $key        = "{$stock_type}_display";
    $style_name = $cron_config['banner']['styels'][$key];
    $style      = isset($BannerConfigs[$style_name]) ? $BannerConfigs[$style_name] : false;

    if ($style) {
        $is_good     = false;
        $style_found = true;

        foreach ($style as $config => $value) {
            $banner_url = getBannerURL('display', $cron_config, $car, $config, $is_good);

            if ($banner_url) {
                if ($is_good == 2) {
                    $good_car = $car;
                } elseif ($is_good == 1) {
                    $medium_car = $car;
                } else {
                    $worst_car = $car;
                }
            }

            if ($good_car) {
                break;
            }
        }

        if ($good_car) {
            break;
        }
    } else {
        continue;
    }
}

if (!$style_found) {
    echo '<p class="text-info"><i>Banner Style Unavailable For This dealership.</i></p>';
    $ignore = true;
}

if (!$good_car && $medium_car) {
    $good_car = $medium_car;
}

if (!$good_car && $worst_car) {
    $good_car = $worst_car;
}

function getBannerURL($directive, $cron_config, $car, $config, &$isGood)
{
    $isGood = 0;
    $price  = $car["price"];
    $hst    = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;

    if (numarifyPrice($price) >= 0) {
        $isGood++;
    } else {
        $price = '';
    }

    if ($car['stock_type'] == 'used' && count($car["images"]) < 1) {
        return false;
    }

    if ($car['stock_type'] == 'new' && count($car["images"]) < 1) {
        return false;
    }

    if (count($car["images"]) > 1) {
        $isGood++;
    }

    $stock_type = $car['stock_type'];
    $year       = $car["year"];
    $make       = $car['make'];
    $model      = $car['model'];
    $template   = $cron_config["banner"]["template"];
    $image_url1 = $car["images"][0];
    $image_url2 = $car["images"][1];

    $headline = processTextTemplate("[make] [model]", $car);

    if (isset($cron_config['title2'])) {
        $headline = processTextTemplate($cron_config['title2'], $car);
    }

    $key              = $stock_type . '_' . $directive;
    $type             = $stock_type . $directive;
    $banner_image_url = GetBaseURL() .
    "../adwords3/banner.php?config=" . rawurlencode($config) .
    "&template=" . rawurlencode($template) .
    "&style=" . rawurlencode(@$cron_config["banner"]["styels"][$key]) .
    "&type=" . rawurlencode($type) .
    "&stock_number=" . rawurlencode($car['stock_number']) .
    "&year=" . rawurlencode($year) .
    "&title=" . rawurlencode($headline) .
    "&make=" . rawurlencode($make) .
    "&model=" . rawurlencode($model) .
    "&price=" . rawurlencode($price) .
    "&img1=" . rawurlencode($image_url1) .
    "&img2=" . rawurlencode($image_url2) .
    "&title_color=" . rawurlencode(@$cron_config["banner"]["font_color"]) .
        "&show_was_is_price=1";

    if ($hst) {
        $banner_image_url .= "&hst=true";
    }

    if (isset($cron_config['banner']['params'])) {
        foreach ($cron_config['banner']['params'] as $k => $v) {
            $banner_image_url .= "&$k=$v";
        }
    }

    return $banner_image_url;
}

function getSwfURL($directive, $cron_config, $car, $config)
{
    $price = $car["price"];
    $hst   = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;

    if ($hst) {
        $price = "";
    }

    if (count($car["images"]) < 1) {
        return false;
    }

    $tmp_biweekly = $price;
    $text         = '';

    if (!numarifyPrice($price)) {
        $price = '';
    }

    if (!numarifyPrice($tmp_biweekly)) {
        $tmp_biweekly = '';
    }

    if ($car['stock_type'] === 'used' && isset($cron_config['biweekly']) && $cron_config['biweekly']) {
        $tmp_biweekly = $car['biweekly'];
        $text         = 'estimated bi-weekly';
        if (numarifyPrice($tmp_biweekly) == 0) {
            $tmp_biweekly = '';
        }

    }

    $stock_type = $car['stock_type'];
    $year       = $car["year"];
    $make       = $car['make'];
    $model      = $car['model'];
    $template   = $cron_config["banner"]["template"];
    $image_url1 = $car["images"][0];
    $image_url2 = $car["images"][1];
    $image_url3 = $car["images"][2];
    $image_url4 = $car["images"][3];
    $image_url5 = $car["images"][4];

    if (!$image_url2) {
        $image_url2 = $image_url1;
    }

    if (!$image_url3) {
        $image_url3 = $image_url1;
    }

    if (!$image_url4) {
        $image_url4 = $image_url2;
    }

    if (!$image_url5) {
        $image_url5 = $image_url1;
    }

    $type             = $stock_type . $directive;
    $banner_image_url = GetBaseURL() .
    "../adwords3/swf-processor.php?size=" . rawurlencode($config) .
    "&template=" . rawurlencode($template) .
    "&style=" . rawurlencode(@$cron_config["banner"]["flash_style"]) .
    "&type=" . rawurlencode($type) .
    "&year=" . rawurlencode($year) .
    "&make=" . rawurlencode($make) .
    "&model=" . rawurlencode($model) .
    "&price=" . rawurlencode($price) .
    "&biweekly=" . rawurlencode($tmp_biweekly) .
    "&text=" . rawurlencode($text) .
    "&img1=" . rawurlencode($image_url1) .
    "&img2=" . rawurlencode($image_url2) .
    "&img3=" . rawurlencode($image_url3) .
    "&img4=" . rawurlencode($image_url4) .
    "&img5=" . rawurlencode($image_url5);

    if (isset($cron_config['banner']['border_color'])) {
        $banner_image_url .= '&border_color=' . rawurlencode($cron_config['banner']['border_color']);
    }

    return $banner_image_url;
}