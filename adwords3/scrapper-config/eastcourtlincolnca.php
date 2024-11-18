<?php
global $scrapper_configs;
$scrapper_configs["eastcourtlincolnca"] = array( 
	"entry_points" => array(
	'all'   => 'https://eastcourtlincoln.ca/data/inventory.json?ts=' . time(),
                       
         ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/view\/(?:new|used)-[0-9]{4}-/i',
        'ajax_url_match'    => '/api/v1/lead',
        'ajax_resp_match'   => '"Type":"RequestMoreInformation"',
        'picture_selectors' => ['.lb-image','.slick-slide'],
        'picture_nexts'     => ['.lb-next'],
        'picture_prevs'     => ['.lb-prev'],
        'custom_data_capture'   => function($url, $data){
        
            $objects = json_decode($data);
            
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->vehicles as $obj)
            {
                if($obj->salepending) { continue; }
                $car_data = array(
                    'stock_number'      => $obj->stocknumber?$obj->stocknumber:$obj->id,
                    'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->bodystyle,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->mileage,
                    'url'               => "https://eastcourtlincoln.ca/view/" . strtolower($obj->condition) .
                                           '-' . strtolower($obj->year) . '-' . strtolower($obj->make) . '-' . strtolower($obj->model) . 
                                           '-' . strtolower($obj->id) . '/',
                    'exterior_color'    => $obj->exteriorcolor,
                    'certified'         => $obj->certified?1:0,
                    'images'            => $obj->picture
                );
                
               $details_url = "https://eastcourtlincoln.ca/data/{$obj->id}.json?{$obj->timestamp}";
                
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
 

