<?php
    global $scrapper_configs;

    $scrapper_configs['fostersrv'] = array(
        'entry_points' => array(
            'new'   => 'http://www.fostersrv.com/imglib/Inventory/cache/2141/NVehInv.js',
            'used'  => 'http://www.fostersrv.com/imglib/Inventory/cache/2141/UVehInv.js'
        ),
        'vdp_url_regex'         => '/https?:\/\/www.fostersrv.com\/default.asp\?page=x(?:PreOwned|New)InventoryDetail/',
        'ajax_url_match'        => '/ajax/xxSubmitForm.asp',
        'vdp_page_regex'        => '/http:\/\/www.fostersrv.com\/default.asp\?page=x(?:PreOwned|New)InventoryDetail/',
        'required_params'       => array('page', 'id'),
        'use-proxy'             => true,
        'picture_selectors' => ['.camera_thumbs_cont ul li'],
        'picture_nexts'     => ['.camera_next'],
        'picture_prevs'     => ['.camera_prev'],
        'details_start_tag'     => 'var Vehicles=',
        'custom_data_capture'   => function($url, $data){
            $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
            $objects = json_decode($tdata);
            
            if(!$objects) { slecho($tdata); }
            
            $to_return = array();
            
            foreach($objects as $obj)
            {
               // if($obj->makeid == 0) { continue; }
                
                $car_data = array(
                    'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                    'year'              => $obj->bike_year,
                    'make'              => $obj->manuf,
                    'model'             => $obj->model,
                    'body_style'        => $obj->catname,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->miles,
                    'url'               => "http://www.fostersrv.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                    'exterior_color'    => $obj->color,
                    'images'            => array()
                );
                
                if($obj->bike_image)
                {
                    $iu = $obj->bike_image;
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/300x225/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
                
                if($obj->image2)
                {
                    $iu = $obj->image2;
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/300x225/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
                
                $car_data['all_images'] = implode('|', $car_data['images']);
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/data-src="(?<img_url>\/\/cdn.dealerspike.com\/imglib\/[^"]+)/'
    );