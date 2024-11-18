<?php
global $scrapper_configs;

$scrapper_configs['i_35rvcentercom'] = array(
    'entry_points' => array(
        'used'  => 'https://www.i-35rvcenter.com/imglib/Inventory/cache/5397/VehInv.js?v=4313993',
    ),
    'use-proxy' => true,
    'vdp_url_regex'     => '/\/default.asp\?page/i',
    'required_params'   => array('page','id'),
    'refine'    => false,

    'picture_selectors' => ['.vehicle-thumb'],
    'picture_nexts' => ['.fa.fa-caret-right'],
    'picture_prevs' => ['.fa.fa-caret-left'],

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
                   $url="https://www.i-35rvcenter.com/default.asp?page=xInventoryDetail";               
               }
       
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'vin'               => $obj->vin,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => $obj->manuf,
                   'model'             => $obj->model,
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => $obj->miles,
                  // 'url'               => "http://www.alexandriacampingcentre.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->vehtypename,
                   'engine'            => $obj->engine,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
 