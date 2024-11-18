<?php
    global $scrapper_configs;

    $scrapper_configs['mainlinerv'] = array(
        'entry_points' => array(
            'new'   => 'https://www.mainlinerv.ca/imglib/Inventory/cache/2346/NVehInv.js',
            'used'  => 'https://www.mainlinerv.ca/imglib/Inventory/cache/2346/UVehInv.js'
        ),
        'vdp_url_regex'         => '/https:\/\/www.mainlinerv.ca\/default.asp\?page=x(?:PreOwned|New|)InventoryDetail/',
        'ajax_url_match'        => '/ajax/xxSubmitForm.asp',
        'vdp_page_regex'        => '/http:\/\/www.mainlinerv.ca\/default.asp\?page=x(?:PreOwned|New|)InventoryDetail/',
        'required_params'       => array('page', 'id'),
        'use-proxy'             => true,
        
        'picture_selectors' => ['.background-image'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag'     => 'var Vehicles=',
        'custom_data_capture'   => function($url, $data){
            $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
            $objects = json_decode($tdata);
            
            if(!$objects) { slecho($tdata); }
            
            $to_return = array();
            
            foreach($objects as $obj)
            {
                $car_data = array(
                    'stock_number'      => $obj->stockno?$obj->stockno:  md5("http://www.mainlinerv.ca/default.asp?page=xNewInventoryDetail&id={$obj->id}"),
                    'year'              => $obj->bike_year,
                    'make'              => $obj->manuf,
                    'model'             => $obj->model,
                    'body_style'        => $obj->vehtypename,
                    'price'             => ($obj->price==0)?'Please Call':$obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->miles,
                    'url'               => "http://www.mainlinerv.ca/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                    'exterior_color'    => $obj->color,
                    'vin'               => $obj->vin,
                    'images'            => array()
                );
                
                if($obj->bike_image)
                {
                    $iu = $obj->bike_image;
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
                
                if($obj->image2)
                {
                    $iu = $obj->image2;
                    $p1 = substr($iu, 0, 2);
                    $p2 = substr($iu, 2, 2);
                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                }
                
                $car_data['all_images'] = implode('|', $car_data['images']);
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/data-src="(?<img_url>\/\/cdn.dealerspike.com\/imglib\/[^"]+)/'
    );