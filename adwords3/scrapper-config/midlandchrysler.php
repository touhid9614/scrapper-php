<?php
    global $scrapper_configs;

    $scrapper_configs['midlandchrysler'] = array(
        'entry_points' => array(
            'used'   => 'http://www.midlandchrysler.ca/inventory/search?stock_type=USED&page=1&page_length=1000',
            'new'    => 'https://www.midlandchrysler.ca/inventory/search?stock_type=New&page=1&page_length=1000',
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/thank-you\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.carousel-active-slide'],
        'picture_nexts'     => ['.carousel-nav-next'],
        'picture_prevs'     => ['.carousel-nav-prev'],
        'custom_data_capture' => function($url, $resp){
            $start_tag  = 'window.strathcomSearchData =';
            $end_tag    = ',"took"';

            if(stripos($resp, $start_tag)) {
                $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
            }

            if(stripos($resp, $end_tag)) {
                $resp = substr($resp, 0, stripos($resp, $end_tag));
            }
            $resp      .='}}';
            $object     = json_decode($resp);
            $inventory  = $object->data->vehicles;
           // $keys       = json_decode($object->inventory_key);
            
//            $stock_number_key = array_search('vin', $keys);
//            $year_key= array_search('year', $keys);
//            $stock_type_key= array_search('vehicleclass', $keys);
//            $make_key= array_search('make', $keys);
//            $model_key= array_search('model_name', $keys);
//            $trim_key= array_search('model_name', $keys);
//            $body_style_key= array_search('body_style', $keys);
//            $price_key= array_search('sale_price', $keys);
//            $engine_key= array_search('engine', $keys);
//            $transmission_key= array_search('transmission', $keys);
//            $kilometres_key= array_search('odometer', $keys);
//            $exterior_color_key= array_search('exterior_color', $keys);
            
            $to_return = array();
            
            foreach($inventory as $obj)
            {
                $car_data = array(
                    'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->dealer->id,
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim->description,
                   // 'body_style'        => $obj->source->feed->bodyStyle,
                    'price'             => $obj->pricingData->current,
                    'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                    'url'               => "http://www.midlandchrysler.ca/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower($obj->model) .
                                           '-' . strtolower($obj->dealer->city) . '-' . strtolower($obj->dealer->province->name) .
                                           '/' .strtolower($obj->id),
                    'exterior_color'    => $obj->color->exterior->name,
                    'interior_color'    => $obj->color->interior->name,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    'images'            => array_merge($obj->photos->user, $obj->photos->stock)
                    //'interior_color'    => $obj->interior_color
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<img\s*itemprop="image"\s*src="(?<img_url>[^"]+)"\s*width="526" height="394"/'
    );
