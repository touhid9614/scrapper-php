<?php
    global $scrapper_configs;

    $scrapper_configs['medfordford'] = array(
       
        'entry_points' => array(
            'all'   => 'https://search-a5-jazel-tango.jazel-qa.com/api/passthroughsrp?q=(account_id%3A705%20AND%20(vehicle_filter_ids%3A2))&expr.compliance0=make_hash%3D%3D19919777401513964&q.parser=lucene&size=1000&sort=compliance0%20desc%2Chas_price%20desc%2Cdisplay_price%20asc&start=0',
            
        ),
        'vdp_url_regex'         => '/\/(?:new|pre-owned|certified)\/[^\/]+\/[^\/]+\/[0-9]{4}-[^\.]+.html/',
//        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'             => true,
        //'next_method'           => 'POST',
        'content_type'          => 'application/json',
        
        'picture_selectors' => ['.carousel-indicators li'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'custom_data_capture'   => function($url, $data){
        
            $objects = json_decode($data);
            
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->hits->hit as $obj)
            {
                $obj = $obj->fields;
                
             //   $w_regex = '/(?<weekly>\$[0-9,.]+)/';
             //   $weekly = 0;
                
             //   $match = array();
                
            //    if(preg_match($w_regex, $obj->source->feed->trim, $match)) {
             //       $weekly = numarifyPrice($match['weekly']);
             //   }
                   $sata =   json_decode($obj->image);
                 $car_data = array(
                     'stock_type'  => $obj->condition,
                    'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->id,
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->style_name,
                    'price'             => $obj->display_price,
                    //'weekly'            => $weekly,
                    //'biweekly'          => $weekly * 2,
                    'engine'            => $obj->engine_cylinders,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->mileage,
                                           
                    'url'               => $obj->condition=="New"?"https://www.medfordford.com/inventory/" .  'new-vehicles/vehicle/' 
                     . ($obj->vin):"https://www.medfordford.com/inventory/" . "used-cars/vehicle/" .  ($obj->vin),
                     
                   
                                           
                    'exterior_color'    => $obj->exterior_color,
                    'interior_color'    => $obj->interior_color_sidebar,
                  //  'options'           => isset($obj->source->feed->attributes->Options)?$obj->source->feed->attributes->Options:array(),
                    'images'            => array($sata->Source)
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
   
    );

   
    