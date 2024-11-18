<?php
    global $scrapper_configs;

    $scrapper_configs['tazloans'] = array(
        'entry_points' => array(
            'used'  => 'https://www.tazloans.com/inventory/search?stock_type=USED&page=1&page_length=20'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/thank-you\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.carousel .slides>li'],
        'picture_nexts'     => ['.carousel-nav-next'],
        'picture_prevs'     => ['.carousel-nav-prev'],
        'custom_data_capture' => function($url, $resp){
            $inventory= get_total_inventory($url);
            $to_return = array();
            
            foreach($inventory as $obj)
            {
                $car_data = array(
                    'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->dealer->id,
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim->description,
                   // 'body_style'        => $obj->source->feed->bodyStyle,
                    'price'             => $obj->pricingData->current,
                    'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                    'url'               => "https://www.tazloans.com/inventory/" . strtolower($obj->stock_type) .
                                           '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower($obj->model) .
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
        'images_regx' => '/<img\s*itemprop="image"\s*src="(?<img_url>[^"]+)"\s* width="526" height="394"/'
    );
        
function get_total_inventory($url)
{
    $ttl_inventory=[];
    while(check_tazloans_url_exists($url))
    {
        $resp= HttpGet($url);

        $start_tag  = 'window.strathcomSearchData =';
        $end_tag    = ',"filters":';

        if(stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if(stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }
        $resp      .='}}';
        $object     = json_decode($resp);
        $ttl_inventory  = array_merge($ttl_inventory,$object->data->vehicles);

        if($object->data->currentPage + 1 > $object->data->pages) break;

        $arr                = explode('&', $url);
        $next_page_param    = explode('=', $arr[1])[0];
        $next_url           = $arr[0]."&".$next_page_param."=".++$object->data->currentPage."&".$arr[2];
        slecho("Next Page :$next_url");
        $url=$next_url;
    }
    return $ttl_inventory;
}

function check_tazloans_url_exists($file)
{
    $file_headers = http_get_headers($file);
    
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    }
    else {
        $exists = true;
    }
    
    return $exists;
}