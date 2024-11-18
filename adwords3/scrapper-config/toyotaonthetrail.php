<?php
    global $scrapper_configs;

    $scrapper_configs['toyotaonthetrail'] = array(
        'entry_points' => array(
            'new'    => 'https://www.toyotaonthetrail.ca/inventory/search?page=1&page_length=1000&stock_type=New',
            'used'   => 'https://www.toyotaonthetrail.ca/inventory/search?page=1&page_length=1000&stock_type=Used'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/thank-you\//i',
        'use-proxy' => true,
        'custom_data_capture' => function($url, $resp){
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
                    'trim'              => $obj->trim->description?$obj->trim->description:($obj->trim->value." ".$obj->trim->variation),
                    'body_style'        => $obj->body_type,
                    'price'             => round($obj->pricingData->current),
                    'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                    'url'               => "https://www.toyotaonthetrail.ca/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower($obj->model) .
                                           '-' . strtolower(str_replace(' ','-', $obj->dealer->city)) . '-' . strtolower(str_replace(' ','-', $obj->dealer->province->name)) .
                                           //'-' . strtolower($obj->dealer->city) . '-' . strtolower($obj->dealer->province->name) .
                                           '/' .strtolower($obj->id),
                    'exterior_color'    => $obj->color->exterior->name,
                    'interior_color'    => $obj->color->interior->name,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    'images'            => array_merge($obj->photos->user, $obj->photos->stock),
                    'certified'         => in_array('certified',$obj->tags)?1:'',
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<img\s*itemprop="image"\s*src="(?<img_url>[^"]+)"\s*width="526" height="394"/'
    );
        
    add_filter("filter_toyotaonthetrail_field_images", "filter_toyotaonthetrail_field_images");
    
    function filter_toyotaonthetrail_field_images($im_urls)
    {
        if(count($im_urls) < 1) { return array(); }
        
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'photo-coming-soon.jpg');
        });
    }
