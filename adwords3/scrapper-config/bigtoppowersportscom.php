<?php

global $scrapper_configs;
$scrapper_configs["bigtoppowersportscom"] = array(
    'entry_points' => array(
        'new' => 'https://www.bigtoppowersports.com/imglib/Inventory/cache/632/NVehInv.js?v=6912809',
        'used' => 'https://www.bigtoppowersports.com/imglib/Inventory/cache/632/UVehInv.js?v=7348966',
    ),
    'vdp_url_regex' => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
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
                $url = "https://www.bigtoppowersports.com/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.bigtoppowersports.com/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission' => $obj->transmission,
                'stock_number' => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year' => $obj->bike_year,
                'make' => $obj->manuf,
                'model' =>$obj->model,
                'body_style' => $obj->vehtypename,
                'stock_type' => $obj->type == 'U' ? 'used' : 'new',
                'price' => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                'kilometres' => isset($obj->miles) ? $obj->miles : '',
                'url' => $url . '&id=' . $obj->id,
                'exterior_color' => $obj->color,
                'engine' => $obj->engine,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
