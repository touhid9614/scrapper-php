<?php
    global $scrapper_configs;

    $scrapper_configs['futureautomotive'] = array(
     'entry_points' => array(
            'new'   => 'https://futureautomotive.biz/service/inventory/website',
         ),
        'vdp_url_regex'         => '/\/inventory\/27327\/view/i',
        'use-proxy'             => true,
      
      //  'content_type'          => 'application/json',
        'picture_selectors' => ['.thumb-wrapper'],
        'picture_nexts'     => ['.right.control'],
        'picture_prevs'     => ['.left.control'],
        'custom_data_capture'   => function($url, $data){
        
        
            $objects = json_decode($data);
       
            $to_return = array();
            
            foreach($objects as $obj)
            {
                $car_dat=[];
                
                $car_data = array(
                    'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->vin,
                   // 'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->style,
                    'price'             => $obj->specialPrice>0?($obj->specialPrice>$obj->price?$obj->price:$obj->specialPrice):$obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->mileage,
                    'url'               => "https://futureautomotive.biz/inventory/27327/view/$obj->stockNo/Daphne-AL/$obj->year-$obj->make-$obj->model",
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                   // 'certified'         => $obj->CertifiedStatus?1:0,
                    'images'            =>array(),
                );
                
              foreach($obj->pictures as $value)
              {
                  $car_dat[]=$value->url;
                  
              }
            
              $car_data['all_images']=implode("|",$car_dat);
                
                $to_return[] = $car_data;
                
            }
             
            return $to_return;
        },

    );
