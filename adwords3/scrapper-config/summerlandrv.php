<?php

global $scrapper_configs;
  
$scrapper_configs['summerlandrv'] = array(
    'entry_points' => array(
        'new'  => 'https://www.summerlandrv.com/imglib/Inventory/cache/5937/NVehInv.js?v=6449598',
        'used' => 'https://www.summerlandrv.com/imglib/Inventory/cache/5937/UVehInv.js?v=5742353',
      
    ),
    'vdp_url_regex'         => '/\/default.asp\?page=x(?:New|PreOwned|)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
   
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts'     => ['.right.next.carousel-control'],
    'picture_prevs'     => ['.left.prev.carousel-control'],
    'details_start_tag'     => 'var Vehicles=',
        'custom_data_capture'   => function($url, $data){
            $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
           // $$tdata=$tdata . "]";
            $objects = json_decode($tdata);
            
            if(!$objects) { slecho($tdata); }
            
            $to_return = array();
            
            foreach($objects as $obj)
            {
                $car_data = array(
                    'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                    'vin'               => $obj->id,
                    'year'              => $obj->bike_year,
                    'make'              => $obj->manuf,
                    'model'             => $obj->model,
                    'body_style'        => $obj->catname,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->miles,
                    'url'               => "http://www.summerlandrv.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                    'exterior_color'    => $obj->color,
                    'images'            => array()
                );
                
                if($obj->bike_image)
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
                }
                
                $car_data['all_images'] = implode('|', $car_data['images']);
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
     'images_regx'            => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+" data-src="(?<img_url>[^"]+)"/',
     'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);

add_filter('filter_summerlandrv_car_data', 'filter_summerlandrv_car_data');

function filter_summerlandrv_car_data($car_data) {

    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);

    return $car_data;
}

