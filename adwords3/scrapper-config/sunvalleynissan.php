<?php
global $scrapper_configs;
 $scrapper_configs["sunvalleynissan"] = array( 
	 'entry_points' => array(
        'new'   => 'https://www.sunvalleynissan.com/inventory/search?stock_type=New&page_length=1000',
        'used'  => 'https://www.sunvalleynissan.com/inventory/search?stock_type=Used&page_length=1000'
    ),
    'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
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
                    'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->dealer->id,
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim->description,
                    'body_style'        => $obj->body_type,
                    'price'             => $obj->pricingData->current,
                    'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                    'url'               => "https://www.sunvalleynissan.com/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower($obj->model) .
                                           '-' . strtolower($obj->dealer->city) . '-' . strtolower(explode(" ",$obj->dealer->province->name)[0]) . 
                                            '-' . strtolower(explode(" ",$obj->dealer->province->name)[1]) .
                                           '/' .strtolower($obj->id),
                    'exterior_color'    => $obj->color->exterior->name,
                    'interior_color'    => $obj->color->interior->name,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    'images'            => array_merge($obj->photos->user, $obj->photos->stock)
                    //'interior_color'    => $obj->interior_color
                );
                
                $to_return[] = $car_data;
            }
            slecho("End Scrap");
            return $to_return;
        },
        'images_regx' => '/<a href="(?<img_url>[^"]+)">\s*<img class="img-defer" itemprop="image"/'
    );
        add_filter("filter_sunvalleynissan_field_images", "filter_sunvalleynissan_field_images");
    
    function filter_sunvalleynissan_field_images($im_urls)
    {
        if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }
