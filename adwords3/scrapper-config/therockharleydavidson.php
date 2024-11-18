<?php

global $scrapper_configs;

$scrapper_configs['therockharleydavidson'] = array(
    'entry_points' => array(
        'new'   => 'https://www.therockharleydavidson.com/imglib/Inventory/cache/1752/NVehInv.js?v=7348280',
        'used'  => 'https://www.therockharleydavidson.com/imglib/Inventory/cache/1752/UVehInv.js?v=5308943',
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
           $end_tag    = '];';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }
           $resp=$resp . ']';
           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {
               if($obj->type == 'U')   
               {
                   $url="https://www.therockharleydavidson.com/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.therockharleydavidson.com/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                  // 'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => unicodify($obj->manuf),
                   'model'             => unicodify($obj->model),
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                  // 'url'               => "http://www.therockharleydavidson.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->color,
                   'engine'            => $obj->engine,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    add_filter('filter_therockharleydavidson_field_make', 'unicodify');
    add_filter('filter_therockharleydavidson_field_model', 'unicodify');
   // add_filter('filter_therockharleydavidson_field_price','filter_therockharleydavidson_field_price');

    function therockharleydavidson_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }
    
   function filter_therockharleydavidson_field_price($price)
   {
       $split_price = explode(" ", $price);
       $now_pos = array_search('NOW',$split_price);
       $price = $split_price[$now_pos+1];
       
       return $price;
       
       
   }
