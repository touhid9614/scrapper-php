<?php
    global $scrapper_configs;

    $scrapper_configs['mcvaymotors'] = array(
        'entry_points' => array(
            'all'   => 'https://mcvaymotors.com/service/inventory/website',
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/[0-9]*\//i',
        'picture_selectors' => ['.img-list .img'],
        'picture_nexts'     => ['.right-control'],
        'picture_prevs'     => ['.left-control'],
        'custom_data_capture' => function($url, $data){
            $objects = json_decode($data);
            
            $to_return = array();
            
            foreach($objects as $obj)
            {
               // if($obj->salepending) { continue; }
                
                $slug = str_replace(" ", "-", "{$obj->year} {$obj->make} {$obj->model}");
                $car_data = array(
                    'stock_number'      => $obj->stockNo,
                    'vin'               => $obj->vin,
                    'stock_type'        => $obj->used?'used':'new',
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->style,
                    'price'             => $obj->price?$obj->price:"Please Call",
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => round($obj->mileage),
                    'url'               => "https://mcvaymotors.com/inventory/27190/view/{$obj->stockNo}/Pensacola-FL/$slug",
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                );
                
                foreach ($obj->pictures as $picture) {
                    $car_data['images'][] = $picture->url;
                }
                    
                $image_urls                 = implode('|', $car_data['images']);
                $car_data['all_images']     = $image_urls;
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        }
    );
