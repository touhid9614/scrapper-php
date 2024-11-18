<?php
    global $scrapper_configs;

    $scrapper_configs['courtenaykia'] = array(
        'entry_points' => array(
            'all'   => 'http://www.courtenaykia.com/vehicles/'
        ),
        'vdp_url_regex'     => '/\/vehicles\/[0-9]{4}\//i',
        'ty_url_regex'      => '/\/thank-you\//i',
        //'required_params'   => ['saleclass'],
        'use-proxy' => true,
        'picture_selectors' => ['.fotorama__nav__frame'],
        'picture_nexts'     => ['.fotorama__arr--next'],
        'picture_prevs'     => ['.fotorama__arr--prev'],
        
        'custom_data_capture' => function($url, $resp){
            $start_tag  = 'var convertusInventory = ';
            $end_tag    = ";\n";

            if(stripos($resp, $start_tag)) {
                $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
            }

            if(stripos($resp, $end_tag)) {
                $resp = substr($resp, 0, stripos($resp, $end_tag));
            }
            
            $object     = json_decode($resp);
            $inventory  = json_decode($object->inventory);
            $keys       = json_decode($object->inventory_key);
            
            $stock_number_key = array_search('stock_number', $keys); //11
            $vin_key = array_search('vin', $keys); //15
            $year_key = array_search('year', $keys); //16
            $stock_type_key = array_search('saleclass', $keys); //21
            $make_key = array_search('make', $keys); //7
            $model_key = array_search('model_name', $keys); //8
            $trim_key = array_search('trim_name', $keys); //13
            $body_style_key = array_search('body_style', $keys); //1
            $sale_price_key = array_search('sale_price', $keys); //18
            $asking_price_key = array_search('asking_price', $keys); //20
            $retail_price_key = array_search('retail_price', $keys); //21
            $engine_key = array_search('engine', $keys); //4
            $transmission_key = array_search('transmission', $keys); //12
            $kilometres_key = array_search('odometer', $keys); //9
            $exterior_color_key = array_search('exterior_color', $keys); //5



            $to_return = array();

            foreach ($inventory as $obj) {
                $car_data = array(
                    'stock_number' => $obj[$stock_number_key],
                    'stock_type' => strtolower($obj[$stock_type_key]),
                    'year' => $obj[$year_key],
                    'make' => $obj[$make_key],
                    'model' => $obj[$model_key],
                    'trim' => $obj[$trim_key],
                    'body_style' => $obj[$body_style_key],
                    'price' => !empty($obj[$sale_price_key])?$obj[$sale_price_key]:(!empty($obj[$retail_price_key])?$obj[$retail_price_key]:$obj[$asking_price_key]),
                    'engine' => $obj[$engine_key],
                    'transmission' => $obj[$transmission_key],
                    'kilometres' => $obj[$kilometres_key],
                    'url' => "http://www.courtenaykia.com/vehicles/{$obj[$year_key]}/{$obj[$make_key]}/{$obj[$model_key]}/Essex/ON/{$obj[$vin_key]}/",
                    'exterior_color' => $obj[$exterior_color_key],
                 
                );

                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<img src=\'(?<img_url>http:\/\/images\.dealertrend\.com\/[^\']+)/'
    );
