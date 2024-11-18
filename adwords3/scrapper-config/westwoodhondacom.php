<?php
global $scrapper_configs;
$scrapper_configs["westwoodhondacom"] = array( 
       'entry_points' => array(
            'new'   => 'https://www.westwoodhonda.com/data/inventory.json?ts='. time(),
            'used'  => 'https://www.westwoodhonda.com/data/inventory.json?ts='. time(),
        ),
        'vdp_url_regex'     => '/\/view\/(?:new|used)-[0-9]{4}-/i',
        'use-proxy' => true,
        'ajax_url_match'    => '/api/v1/lead',
        'ajax_resp_match'   => '"Type":"RequestMoreInformation"',

        'picture_selectors' => ['.img-responsive.center-block'],
        'picture_nexts'     => ['.lb-next'],
        'picture_prevs'     => ['.lb-prev'],
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
                    // 'body_style'        => $obj->bodystyle,
                    'price'             => $obj->extendedprice>0?$obj->extendedprice:"Please Call",
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => round($obj->mileage),
                    'url'               => "https://www.westwoodhonda.com/view/$slug/",
                    'exterior_color'    => $obj->exteriorcolor
                );
                
                $details_url = "https://westwoodhonda.leadbox.info/data/{$obj->id}.json?{$obj->timestamp}";
                
                slecho("Details Data URL: $details_url");
                
                $details_data = HttpGet($details_url);
                
                if($obj->demo){
                    $car_data['custom'] = "special";
                }
                
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
