<?php
    global $scrapper_configs;

    $scrapper_configs['listowelcityford'] = array(
       'entry_points' => array(
            'new'   => 'https://www.listowelford.com/wp-json/strathcom/vehicles/search?language=en&stock_type=New&page=1&page_length=1000',
            'used'   => 'https://www.listowelford.com/wp-json/strathcom/vehicles/search?language=en&stock_type=Used&page=1&page_length=1000',

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
                    'vin'               => $obj->vin?$obj->vin:$obj->stock_number,
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
                    'url'               => "https://www.listowelford.com/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . str_replace(' ', '%20',strtolower($obj->model)) .
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
            slecho("End Scrap");
            return $to_return;
        },
         'images_regx' => '/<a href="(?<img_url>[^"]+)">\s*<img class="img-defer" itemprop="image"/'
               
    );

add_filter("filter_listowelcityford_field_images", "filter_listowelcityford_field_images");       
function filter_listowelcityford_field_images($im_urls) {
    
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "5dc048df54d6227c9e645b99.jpg");
    }
    );
}
