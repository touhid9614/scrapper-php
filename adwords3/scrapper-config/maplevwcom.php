<?php
global $scrapper_configs;
$scrapper_configs["maplevwcom"] = array( 
	'entry_points' => array(
            'used' => 'https://www.maplevw.com/en/inventory/search/?stock_type=Used&page_length=1000&sort_by=price&sort_order=asc',
            'new'  => 'https://www.maplevw.com/en/inventory/search/?stock_type=New&page_length=1000&sort_by=price&sort_order=asc',

            
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',       
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
                        'url'               => "https://www.maplevw.com/en/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower(str_replace(" ","-",$obj->model))  . '-maple-ontario/' . strtolower($obj->id),
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
    //  add_filter("filter_brownsvw_field_images", "filter_brownsvw_field_images");

    // function filter_brownsvw_field_images($im_urls)
    // {
        
        
    //      if(count($im_urls)<2)
    //         {
    //         return [];
            
    //         }
    //       $retval = [];
        
    //     foreach($im_urls as $img)
    //     {
            
    //          $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
    //     }
        
    //      return array_filter($retval, function($im_url){
    //         return !endsWith($im_url, 'coming-soonv2.jpg');
    //     });
    // }
    
    // 