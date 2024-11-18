<?php

global $scrapper_configs;
$scrapper_configs["motounitedbountiful"] = array(
    'entry_points' => array(
        'used' => 'https://www.motounitedbountiful.com/imglib/Inventory/cache/4084/UVehInv.js?v=8827314',
        'new' => 'https://www.motounitedbountiful.com/imglib/Inventory/cache/4084/NVehInv.js?v=4923460',
        
    ),
    'vdp_url_regex' => '/\/default.asp\?page=x(?:Inventory|NewInventory|PreOwnedInventory)Detail/i',
    'required_params' => array('page', 'id'),
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'custom_data_capture' => function($url, $resp) {
        $start_tag = 'var Vehicles=';
        $end_tag = '];';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }
        $resp = $resp . ']';
        $inventory = json_decode($resp);

        $to_return = array();

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $url = "https://www.motounitedbountiful.com/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.motounitedbountiful.com/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission' => $obj->transmission,
                'stock_number' => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year' => $obj->bike_year,
                'make' => $obj->manuf,
                'model' => $obj->model,
                'body_style' => $obj->vehtypename,
                'stock_type' => $obj->type == 'U' ? 'used' : 'new',
                'price' => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                'kilometres' => isset($obj->miles) ? $obj->miles : '',
                'url' => $url . '&id=' . $obj->id,
                'exterior_color' => $obj->color?$obj->color:'white/black',
                'engine' => $obj->engine,
                'vin'   => !empty($obj->vin) ? $obj->vin : $obj->id,
                'drivetrain'        => $obj->engine,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
        'images_regx'       => '/(?:unitSliderImg">\s*<div class=\'image-container\'>[^\(]+\(|<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src=")(?<img_url>[^(?\)|")]+)/',
);
add_filter('filter_motounitedbountiful_car_data', 'filter_motounitedbountiful_car_data');

function filter_motounitedbountiful_car_data($car_data) {

     //   $car_data['exterior_color']=str_replace(["GREEN, GRAY, BLACK & WHITE","CARBON BLACK & ORANGE","Ext: Onyx Black, Jet Black Metal Flake, & Medallion Metal Flake. Int: Mystic White & Mojave Brown","Reef Blue Metal Flake & Mystic White","EXT: GRAY & RED FLAKE, ONYX BLACK STRIPE & MYSTIC WHITE HULL"], ["Green Gray Black and White","CARBON BLACK ORANGE","Onyx Black, Jet Black Metal Flake,and Medallion Metal Flake","Reef Blue Metal Flake and Mystic White","EXT: GRAY and RED FLAKE, ONYX BLACK STRIPE and MYSTIC WHITE HULL"], $car_data['exterior_color']);
$car_data['exterior_color'] = str_replace('&', 'and', $car_data['exterior_color']);
    return $car_data;
}

