<?php

global $scrapper_configs;

$scrapper_configs['tandthonda'] = array(
    'entry_points' => array(
       'used' => 'https://www.tandthonda.ca/api/v1/vehicles?category=used&order=price_asc&page=1',
       'new' => 'https://www.tandthonda.ca/api/v1/vehicles?category=new&order=in_stock_date_asc&page=1',
    
    ),
    'vdp_url_regex'     => '/\/inventory\/(?:new|used)-[0-9]{4}/i',
    
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.item.ng-scope'],
    'picture_nexts'     => ['.btn.btn-default.btn-lg.pull-right'],
    'picture_prevs'     => ['.btn.btn-default.btn-lg.pull-left'],

    'custom_data_capture' => function($url, $resp){
          
           $object = json_decode($resp);
           $inventory = $object->models;

           $to_return = array();

           foreach($inventory as $obj)
           {
               
              
               
               $car_data = array(

                   
                   'stock_number'      => $obj->stock,
                   'year'              => $obj->year,
                   'make'              => $obj->make,
                   'model'             => $obj->model,              
                   'price'             => $obj->price?$obj->price:$obj->pricing->selling_price,
                   'kilometres'        => str_replace("kilometers", "", $obj->mileage),
                   'url'               => str_replace(["%2B"],["+"], $obj->vehicle_url),
                   'exterior_color'    => $obj->exterior_color->name_full,
                   'vin'               => $obj->vin,
                   'description'      => $obj->link_description,
                  

               );


                $images=[];
               foreach ($obj->images as $img){
                 
                  $images[]=$img->href;  
                    
                }
              
                $car_data['all_images'] = str_replace('thumb_', '', implode("|", $images));
               
                $to_return[] = $car_data;
           }

           return $to_return;
       },
  
    'next_query_regx' => '/"next(?<param>Page)":(?<value>[0-9]+)/',
    
);

