<?php
    global $scrapper_configs;

    $scrapper_configs['denhamdodge'] = array(
        'entry_points' => array(
            'all'   => 'http://denhamdodge.ca/data/inventory.json?ts=' . time(),
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/view\/(?:new|used)-[0-9]{4}-/i',
        'ajax_url_match'    => '/api/v1/lead',
        'ajax_resp_match'   => '"Type":"RequestMoreInformation"',
        'custom_data_capture' => function($url, $data){
            $objects = json_decode($data);
            
            $to_return = array();
            
            foreach($objects->vehicles as $obj)
            {
                if($obj->salepending) { continue; }
                
                $slug = strtolower(str_replace(" ", "-", "{$obj->condition} {$obj->year} {$obj->make} {$obj->model} {$obj->id}"));
                $car_data = array(
                    'stock_number'      => $obj->stocknumber,
                    'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->bodystyle,
                    'price'             => $obj->price>0?$obj->price:"Please Call",
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => round($obj->mileage),
                    'url'               => "http://denhamdodge.ca/view/$slug/",
                    'exterior_color'    => $obj->exteriorcolor
                );
                
                $details_url = "http://denhamdodge.leadbox.info/data/{$obj->id}.json?{$obj->timestamp}";
                
                slecho("Details Data URL: $details_url");
                
                $details_data = HttpGet($details_url);
                
                if($details_data) {
                    $details_obj = json_decode($details_data);
                    $car_data['interior_color'] = $details_obj->interiorcolor;
                    $car_data['images']         = $details_obj->pictures;
                    array_walk($car_data['images'], function(&$img_url) use($car_data){
                        $img_url = urlCombine($car_data['url'], $img_url);
                    });
                    $image_urls                 = implode('|', $car_data['images']);
                    $car_data['all_images']     = $image_urls;
                }
                else {
                    slecho('Error: Unable to load details data');
                }
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        }
    );