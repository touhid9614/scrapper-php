<?php
    global $scrapper_configs;

    $scrapper_configs['kentvilletoyota'] = array(
        'entry_points' => array(
            'all'   => 'http://www.kentvilletoyota.com/vehicles/',     
        ),
        'vdp_url_regex'     => '/\/vehicles\/[0-9]{4}\//i',
        'ty_url_regex'      => '/\/thank-you\//i',
        //'requird_params'    =>['saleclass'],
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
            $price_key = array_search('sale_price', $keys); //17
            $engine_key = array_search('engine', $keys); //4
            $transmission_key = array_search('transmission', $keys); //12
            $kilometres_key = array_search('odometer', $keys); //9
            $exterior_color_key = array_search('exterior_color', $keys); //5
            $title_key          = array_search('vehicle_title', $keys); //25
            
            $to_return = array();
            
            foreach($inventory as $obj)
            {
                $car_data = array(
                    'title'             =>$obj[$title_key],
                    'stock_number'      => $obj[$stock_number_key],
                    'stock_type'        => strtolower($obj[$stock_type_key]),
                    'year'              => $obj[$year_key],
                    'make'              => $obj[$make_key],
                    'model'             => $obj[$model_key],
                    'trim'              => $obj[$trim_key],
                    'body_style'        => $obj[$body_style_key],
                    'price'             => $obj[$price_key],
                    'engine'            => $obj[$engine_key],
                    'transmission'      => $obj[$transmission_key],
                    'kilometres'        => $obj[$kilometres_key],
                    'url'               => "http://www.kentvilletoyota.com/vehicles/{$obj[$year_key]}/{$obj[$make_key]}/{$obj[$model_key]}/Kentville/NS/{$obj[$vin_key]}/",//?saleclass={$obj[$stock_type_key]}",
                    'exterior_color'    => $obj[$exterior_color_key],
                    //'interior_color'    => $obj->interior_color
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<img src=\'(?<img_url>http:\/\/images\.dealertrend\.com\/[^\']+)/'
    );
        
     add_filter("filter_kentvilletoyota_field_images", "filter_kentvilletoyota_field_images");
    
    function filter_kentvilletoyota_field_images($im_urls)
    {
        slecho("Filtering Image");
        
        return array_filter($im_urls, function($im_url){
            return (stripos($im_url, 'ConvertusSRPDefaultImage-V2.jpg')||stripos($im_url, '63800245/ddbc996c0791b6a477e4b984113af1243aff3922_large.jpeg')) == false;
        });
    }
