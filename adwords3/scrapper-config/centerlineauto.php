<?php
global $scrapper_configs;
$scrapper_configs["centerlineauto"] = [
    'entry_points'         => [
        'used' => 'https://www.centerlineauto.com/imglib/Inventory/cache/5408/NVehInv.js?v=5372113',
        'new'  => 'https://www.centerlineauto.com/imglib/Inventory/cache/5408/UVehInv.js?v=6719724'
    ],
    
    'vdp_url_regex'        => '/\/default.asp\?page=x(?:New|PreOwned|)InventoryDetail/i',
    'required_params'      => ['page', 'id'],
    'use-proxy'            => true,
    'refine'               => false,

    'picture_selectors'    => ['.photo'],
    'picture_nexts'        => ['.right'],
    'picture_prevs'        => ['.left'],

    'custom_data_capture'  => function ($url, $resp) {
        $start_tag = 'var Vehicles=';
        $end_tag   = '];';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $resp      = $resp . ']';
        $inventory = json_decode($resp);
        $to_return = [];

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $stk_url = "https://www.centerlineauto.com/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $stk_url = "https://www.centerlineauto.com/default.asp?page=xNewInventoryDetail";
            }

            $car_data = [
                'transmission'   => $obj->transmission,
                'stock_number'   => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year'           => $obj->bike_year,
                'make'           => $obj->manuf,
                'model'          => preg_replace('/\s+[A-z]*[0-9]+[A-z]*/', '', $obj->model),
                'body_style'     => $obj->vehtypename,
                'stock_type'     => $obj->type == 'U' ? 'used' : 'new',
                'price'          => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                'kilometres'     => isset($obj->miles) ? $obj->miles : '',
                'url'            => $stk_url . '&id=' . $obj->id,
                'exterior_color' => str_replace('&', 'and', $obj->color),
                'vin'            => $obj->vin,
                'engine'         => $obj->engine,
                'drivetrain'     => $obj->engine
            ];

            $to_return[] = $car_data;

            // They have url variations in website and two different url will lead to same vehicle
            $url = "https://www.centerlineauto.com/default.asp?page=xInventoryDetail";
            $car_data['url'] = $url . '&id=' . $obj->id;




            $response_data = HttpGet($car_data['url']);
            $regex         = '/<div class="unitText">\s*<div>(?<description>[^<]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }





            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'          => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
];