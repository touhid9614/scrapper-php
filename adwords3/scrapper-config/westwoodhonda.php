<?php
    global $scrapper_configs;
   
    $scrapper_configs['westwoodhonda'] = array(
         'entry_points' => array(
            'all'   => 'https://www.westwoodhonda.com/vehicles/new/'
        ),
     
        'picture_selectors' => ['.fotorama__nav__shaft .fotorama__nav__frame'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
     
        'vdp_url_regex'     => '/\/vehicles\/[0-9]{4}\//i',
        'ty_url_regex'      => '/\/thank-you\//i',
        //'required_params'   => ['dealer_name'],
        'use-proxy' => true,
        'custom_data_capture' => function($url, $resp){
            $start_tag  = 'var convertusInventory =';
            $end_tag    = '}}};';

            if(strripos ($resp, $start_tag)) {
                $resp = substr($resp, strripos ($resp, $start_tag) + strlen($start_tag));
            }
            
           
            if(stripos($resp, $end_tag)) {
                $resp = substr($resp, 0, stripos($resp, $end_tag));
            }
            //slecho($resp);
           //logme_nostrip($resp);
             $resp=$resp . "}}}";

            $object         = json_decode($resp);
            $inventory      = json_decode($object->inventory);
            $inventory_key  = json_decode($object->inventory_key);
            
            $to_return = array();
            
            foreach($inventory as $obj)
            {
                $stock_number_key   = array_search('stock_number', $inventory_key); //11
                $vin_key            = array_search('vin', $inventory_key); //15
                $year_key           = array_search('year', $inventory_key); //16
                $stock_type_key     = array_search('sale_class', $inventory_key); //21
                $make_key           = array_search('make', $inventory_key); //7
                $model_key          = array_search('model', $inventory_key); //8
                $trim_key           = array_search('trim', $inventory_key); //13
                $body_style_key     = array_search('body_style', $inventory_key); //1
                $price_key          = array_search('final_price', $inventory_key); //17
                $asking_price_key   = array_search('initial_price', $inventory_key); //19
                $engine_key         = array_search('engine', $inventory_key); //4
                $transmission_key   = array_search('transmission', $inventory_key); //12
                $kilometres_key     = array_search('odometer', $inventory_key); //9
                $exterior_color_key = array_search('exterior_color', $inventory_key); //5
                $title_key          = array_search('vehicle_title', $inventory_key); //25
            
                $_make  = urldecode($obj[$make_key]);
                $_model = urldecode($obj[$model_key]);
                
                $car_data = array(
                    'title'             =>$obj[$title_key],
                    'stock_number'      => $obj[$stock_number_key],
                    'stock_type'        => strtolower($obj[$stock_type_key]),
                    'year'              => $obj[$year_key],
                    'make'              => urldecode($obj[$make_key]),
                    'model'             => urldecode($obj[$model_key]),
                    'trim'              => $obj[$trim_key],
                    'body_style'        => $obj[$body_style_key],
                    'price'             => $obj[$price_key]>0?($obj[$price_key]<$obj[$asking_price_key]?$obj[$price_key]:$obj[$asking_price_key]):$obj[$asking_price_key],
                    'engine'            => $obj[$engine_key],
                    'transmission'      => $obj[$transmission_key],
                    'kilometres'        => $obj[$kilometres_key],
                    'url'               => "https://www.westwoodhonda.com/vehicles/{$obj[$year_key]}/$_make/$_model/Port%20Moody/BC/{$obj[$vin_key]}/?sale_class={$obj[$stock_type_key]}",
                    'exterior_color'    => $obj[$exterior_color_key],
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => "/<img src=\'(?<img_url>[^\']+)\' cvrt-data-id/"
    );
        
    
        
