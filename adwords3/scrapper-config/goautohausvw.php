<?php

global $scrapper_configs;

$scrapper_configs['goautohausvw'] = array(
   'entry_points' => array(
            'used' => 'https://www.goautohausvw.ca/en/inventory/search?stock_type=Used&sort_by=price&sort_order=ASC&page=1&page_length=1000',
            'new'  => 'https://www.goautohausvw.ca/en/inventory/search?stock_type=New&sort_by=price&sort_order=ASC&page=1&page_length=1000',
            
        ),
        'vdp_url_regex'     => '/inventory\/(?:new|used)\/[0-9]{4}-/i',
            //'ty_url_regex'      => '/\/thank-you\//i',
            'use-proxy' => true,
            'picture_selectors' => ['.carousel .slides>li'],
            'picture_nexts'     => ['.carousel-nav-next'],
            'picture_prevs'     => ['.carousel-nav-prev'],
            
            'custom_data_capture' => function($url, $resp){
                slecho("Statring Scrap...");
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
              
                $to_return = array();
                
                foreach($inventory as $obj)
                {
                    $car_data = array(
                        'stock_number'      => $obj->stock_number,
                        'vin'               => $obj->vin,
                        'drivetrain'        => $obj->driveType,
                        'fuel_type'         => $obj->fuel_type,
                        'year'              => $obj->year,
                        'make'              => $obj->make,
                        'model'             => $obj->model,
                        'body_style'        => $obj->body_type,
                        'trim'              => $obj->trim->description,
                       // 'body_style'        => $obj->source->feed->bodyStyle,
                        'price'             => $obj->pricingData->current,
                        'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                        'transmission'      => $obj->transmission,
                        'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                        'url'               => "https://www.goautohausvw.ca/en/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' .strtolower(explode(" ",$obj->model)[0])  . '-'.strtolower(explode(" ",$obj->model)[1]).
                                           '-' . strtolower($obj->dealer->city) . '-' . strtolower(" ",$obj->dealer->province->name) .
                                           '/' .strtolower($obj->id),
                        'exterior_color'    => $obj->color->exterior->name,
                        'interior_color'    => $obj->color->interior->name,
                        'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                       // 'images'            => array_merge($obj->photos->user, $obj->photos->stock)
                        //'interior_color'    => $obj->interior_color
                    );
                    
                    $to_return[] = $car_data;
                }
                slecho("End Scrap");
                return $to_return;
            },
          'images_regx' => '/<a href="(?<img_url>[^"]+)">\s*<img class="img-defer" itemprop="image"/'
        );
     add_filter("filter_goautohausvw_field_images", "filter_goautohausvw_field_images");

    function filter_goautohausvw_field_images($im_urls)
    {
 
    $final_image=[];
   $check_exist=["d8da3156e211a996ad8ec54be008c430e8a441e1-0535a0.png","d8da3156e211a996ad8ec54be008c430e8a441e1-f4128d.png","d8da3156e211a996ad8ec54be008c430e8a441e1-22ba09.png"
       ,"d8da3156e211a996ad8ec54be008c430e8a441e1-69d7ce.png","d8da3156e211a996ad8ec54be008c430e8a441e1-c033c1.png","d8da3156e211a996ad8ec54be008c430e8a441e1-56b94e.png","d8da3156e211a996ad8ec54be008c430e8a441e1-4a910b.png","d8da3156e211a996ad8ec54be008c430e8a441e1-db43ed.png","d8da3156e211a996ad8ec54be008c430e8a441e1-efb01e.png"
       ,"d8da3156e211a996ad8ec54be008c430e8a441e1-54b0ad.png","d8da3156e211a996ad8ec54be008c430e8a441e1-33c9ae.png","d8da3156e211a996ad8ec54be008c430e8a441e1-1e0c0e.png","d8da3156e211a996ad8ec54be008c430e8a441e1-b770e6.png","d8da3156e211a996ad8ec54be008c430e8a441e1-fafc68.png"];

   foreach ($im_urls as $images){

       $contents = explode('/', $images);
       if (!in_array(end($contents), $check_exist))
       {
           array_push($final_image,$images);
       }
   }
   $retval = [];
        
        foreach($final_image as $img)
        {
            $retval[] = str_replace('|', '%7c', $img);
        }
        
        if(count($retval) < 2) { return array(); }
        
        return $retval;
 
        

    }