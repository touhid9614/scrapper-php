<?php
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'utils.php';
    
    function get_banner_url($car, $config, $template, $cron_config, $directive, $custom_horizontal = null, $custom_vertical = null)
    {
        global $BannerConfigs;
        
        $key = $car['stock_type'].'_'.$directive;
        $type = $car['stock_type'].$directive;
        $style = @$cron_config['banner']['styels'][$key];
        
        if(!$style) return null;
        
        if(!isset($BannerConfigs[$style])) return;
        
        $year       = $car['year'];
        $headline2  = prettyString($car['make'] . ' ' . $car['model']);
        $price      = $car['price'];
        if (numarifyPrice($price) == 0) {
            $price = '';
        }
        $image_url1 = @$car['images'][0];
        $image_url2 = @$car['images'][1];
        
        $banner_image_url = GetBaseURL() .
            "../adwords3/banner.php?config=" . rawurlencode($config) .
            "&template=" . rawurlencode($template) .
            "&style=" . rawurlencode($style) .
            "&type=" . rawurlencode($type) .
            "&year=" . rawurlencode($year) .
            "&title=" . rawurlencode($headline2) .
            "&make=" . rawurlencode($car['make']) .
            "&model=" . rawurlencode($car['model']) .
            "&price=" . rawurlencode($price) .
            "&img1=" . rawurlencode($image_url1) .
            "&img2=" . rawurlencode($image_url2) .
            "&title_color=" . rawurlencode(@$cron_config['banner']['font_color']) .
            "&proxy=true";

        if ($custom_horizontal) {
            $banner_image_url .= "&horizontal=" . rawurlencode($custom_horizontal);
        }
        if ($custom_vertical) {
            $banner_image_url .= "&vertical=" . rawurlencode($custom_vertical);
        }
        
        return $banner_image_url;
    }

    function resolve_cars($cron_name, $cron_config, &$tabs, &$good_new_car, &$good_used_car)
    {
        global $connection, $BannerConfigs;
        
        $tabs = array();

        $stock_types = array('new' , 'used');
        $directives = array('display', 'retargeting', 'marketbuyers', 'combined');

        foreach($directives as $directive)
        {
            foreach($stock_types as $stock_type)
            {
                $key = $stock_type . '_' . $directive;

                if(isset($cron_config['create'][$key]) && $cron_config['create'][$key] == yes)
                {
                    $tabs[$stock_type.$directive] = array(
                        'stock_type'    => $stock_type,
                        'directive'     => $directive,
                        't_directive'   => $directive
                    );

                    if($directive == 'combined') $tabs[$stock_type.$directive]['t_directive'] = 'display';
                }
            }
        }

        $mutex = Mutex::create();

        $db_connect = new DbConnect($cron_name);

        $cars_db = array();
        $ads_db = array();
        $all_cars_db = array();

        $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db);

        $good_new_car = null;
        $medium_new_car = null;
        $worst_new_car = null;
        $good_used_car = null;
        $medium_used_car = null;
        $worst_used_car = null;

        foreach($all_cars_db as $car)
        {
            $stock_type = $car['stock_type'];

            $key        = 'new_display';
            $style_name = $cron_config['banner']['styels'][$key];
            $style = isset($BannerConfigs[$style_name])? $BannerConfigs[$style_name] : false;

            if(!$style) return "No display style specified";

            $is_good = false;

            foreach($style as $config => $value)
            {
                $banner_url = getBannerURL('display', $cron_config, $car, $config, $is_good);

                if($banner_url)
                {
                    if($stock_type == 'new') if($is_good == 2) $good_new_car = $car; elseif($is_good == 1) $medium_new_car = $car; else $worst_new_car = $car;
                    if($stock_type == 'used') if($is_good == 2) $good_used_car = $car; elseif($is_good == 1) $medium_used_car = $car; else $worst_used_car = $car;

                    if($good_new_car && $good_used_car)
                    {
                        break;
                    }
                }
            }

            if($good_new_car && $good_used_car)
            {
                break;
            }
        }

        if(!$good_new_car && $medium_new_car) $good_new_car = $medium_new_car;
        if(!$good_new_car && $worst_new_car) $good_new_car = $worst_new_car;
        if(!$good_used_car && $medium_used_car) $good_used_car = $medium_used_car;
        if(!$good_used_car && $worst_used_car) $good_used_car = $worst_used_car;
    }
    
    function getBannerURL($directive, $cron_config, $car, $config, &$isGood)
    {
        $isGood = 0;

        $price      = $car["price"];

        if(numarifyPrice($price))
        {
            $isGood++;
        }
        else
        {
            $price = '';
        }

        if($car['stock_type'] == 'used' && count($car["images"]) < 1) return false;
        if($car['stock_type'] == 'new'  && count($car["images"]) < 1) return false;

        if(count($car["images"]) > 1) $isGood++;

        $stock_type = $car['stock_type'];
        $year       = $car["year"];
        $make       = $car['make'];
        $model      = $car['model'];
        $headline   = $car['make'] . " " . $car["model"];
        $template   = $cron_config["banner"]["template"];
        $image_url1 = $car["images"][0];
        $image_url2 = $car["images"][1];

        $key    = $stock_type . '_'. $directive;
        $type   = $stock_type . $directive;
        $banner_image_url = GetBaseURL() .
                    "../adwords3/banner.php?config=" . rawurlencode($config) .
                    "&template=" . rawurlencode($template) .
                    "&style=" . rawurlencode(@$cron_config["banner"]["styels"][$key]) .
                    "&type=" . rawurlencode($type) .
                    "&year=" . rawurlencode($year) .
                    "&title=" . rawurlencode($headline) .
                    "&make=" . rawurlencode($make) .
                    "&model=" . rawurlencode($model) .
                    "&price=" . rawurlencode($price) .
                    "&img1=" . rawurlencode($image_url1) .
                    "&img2=" . rawurlencode($image_url2) .
                    "&title_color=" . rawurlencode(@$cron_config["banner"]["font_color"]);
        return $banner_image_url;
    }

    function getSwfURL($directive, $cron_config, $car, $config)
    {
        $price      = $car["price"];

        //if(!numarifyPrice($price)) return false;

        if(count($car["images"]) < 1) return false;

        $tmp_biweekly = $price;
        $text = '';

        if(!numarifyPrice($price)) $price = '';
        if(!numarifyPrice($tmp_biweekly)) $tmp_biweekly = '';

        if($car['stock_type'] === 'used' && isset($cron_config['biweekly']) && $cron_config['biweekly'])
        {
            $tmp_biweekly   = $car['biweekly'];
            $text           = 'estimated bi-weekly';
            if(numarifyPrice($tmp_biweekly) == 0) $tmp_biweekly = '';
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

        if(!$image_url2) $image_url2 = $image_url1;
        if(!$image_url3) $image_url3 = $image_url1;
        if(!$image_url4) $image_url4 = $image_url2;
        if(!$image_url5) $image_url5 = $image_url1;

        $type   = $stock_type . $directive;
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

        if(isset($cron_config['banner']['border_color']))
        {
            $banner_image_url .= '&border_color=' . rawurlencode($cron_config['banner']['border_color']);
        }

        return $banner_image_url;
    }
    
?>