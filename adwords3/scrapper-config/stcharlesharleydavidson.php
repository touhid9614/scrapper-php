<?php
global $scrapper_configs;
 $scrapper_configs["stcharlesharleydavidson"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.stcharlesharleydavidson.com/imglib/Inventory/cache/3343/NVehInv.js?v=5160215',
        'used' => 'https://www.stcharlesharleydavidson.com/imglib/Inventory/cache/3343/UVehInv.js?v=3629270',
    ),
    'vdp_url_regex' => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
   'required_params' => array('page', 'id'),
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.vehicle-thumb'],
    'picture_nexts' => ['.right.next'],
    'picture_prevs' => ['.left.prev'],
     'details_start_tag'     => 'var Vehicles=',
    'custom_data_capture' => function($url, $resp) {
        $tdata = trim(substr($resp, strlen('var Vehicles=')), ';');
        //$tdata =str_replace("es=","",$tdata);
        $inventory = json_decode($tdata);
        if(!$inventory) { slecho($tdata); }
        $to_return = array();

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $url = "https://www.stcharlesharleydavidson.com/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.stcharlesharleydavidson.com/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission'  => $obj->transmission,
                'stock_number'  => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year'          => $obj->bike_year,
                'make'          => $obj->manuf, 
                'model'         => $obj->model,  
                'body_style'    => $obj->vehtypename,
                'stock_type'    => $obj->type == 'U' ? 'used' : 'new',
                'price'         => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price :(!empty($obj->MSRP)) ? $obj->MSRP :'Call for Price'),
                'kilometres'    => isset($obj->miles) ? $obj->miles : '',
                'url'           => $url . '&id=' . $obj->id,
                'exterior_color'=> $obj->color,
                'engine'        => $obj->engine,
                'vin'           => $obj->vin,
            );

            /*if($obj->bike_image)
            {
                $iu = $obj->bike_image;
                
                if(startsWith($iu, '/')) {
                    $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                }else {
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
            }
            elseif($obj->stock_image)
            {
                $iu = $obj->stock_image;
                
                if(startsWith($iu, '/')) {
                    $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                }else {
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
            }
            
            if($obj->image2)
            {
                $iu = $obj->stock_image;
                
                if(startsWith($iu, '/')) {
                    $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                }else {
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
            }*/

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/(?:unitSliderImg">[^\(]+\(|<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src=")(?<img_url>[^(?\)|")]+)/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
 