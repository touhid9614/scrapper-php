<?php

global $scrapper_configs;

$scrapper_configs['eurorad'] = array(
    'entry_points' => array(
        'new'   => 'https://www.eurorad.ca/imglib/Inventory/shared-cache/3660/NVehInv.js?v=7569654',
        'used'  => 'https://www.eurorad.ca/imglib/Inventory/shared-cache/3660/UVehInv.js?v=8915891',
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'custom_data_capture' => function($url, $resp){
           $start_tag  = 'var Vehicles=';
           $end_tag    = ';';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }

           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {
               if($obj->type == 'U')   
               {
                   $url="https://www.eurorad.ca/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.eurorad.ca/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => unicodify($obj->manuf),
                   'model'             => unicodify($obj->model),
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                  // 'url'               => "http://www.eurorad.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->color,
                   'engine'            => $obj->engine,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/unitSliderImg">\s*[^\:]+\:url\((?<img_url>[^\)]+)/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    add_filter('filter_eurorad_field_make', 'unicodify');
    add_filter('filter_eurorad_field_model', 'unicodify');

    function eurorad_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }

