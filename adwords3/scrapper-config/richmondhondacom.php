<?php
global $scrapper_configs;
$scrapper_configs["richmondhondacom"] = array( 
	'entry_points' => array(
            'used'  => [
                'https://www.richmondhonda.com/api/v1/vehicles?category=used&order=price_asc&page=1',
                'https://www.richmondhonda.com/api/v1/vehicles?category=used&order=price_asc&page=2',
                'https://www.richmondhonda.com/api/v1/vehicles?category=used&order=price_asc&page=3',
                'https://www.richmondhonda.com/api/v1/vehicles?category=used&order=price_asc&page=4'
            ],
             'new'  => [
                'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=1',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=2',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=3',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=4',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=5',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=6',
                 'https://www.richmondhonda.com/api/v1/vehicles?category=new&Page=7',
            ],
    ),
    'vdp_url_regex'     => '/\/express\//i',
    //'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.u-dib .FlexEmbed-content img'],
    'picture_nexts'     => ['.Swipe-control--next button'],
    'picture_prevs'     => ['.Swipe-control--prev button'],

    'custom_data_capture' => function($url, $resp){
          
           $object = json_decode($resp);
           $inventory = $object->models;

           $to_return = array();

           foreach($inventory as $obj)
           {
               
              
               
               $car_data = array(

                   
                   'stock_number'      => !empty($obj->stock)?$obj->stock:$obj->vin,
                   'year'              => $obj->year,
                   'make'              => $obj->make,
                   'model'             => $obj->model,              
                   'price'             => $obj->price?$obj->price:$obj->pricing->msrp,
                   'kilometres'        => $obj->mileage,
                   'url'               => $obj->vehicle_url,
                   'exterior_color'    => $obj->exterior_color->name_full,
                   'vin'               => $obj->vin,
                  

               );
                $images=[];
               foreach ($obj->images as $img){
                    $images[]=$img->href;
                }
            //   $car_data['all_images']=implode('|', $images);
               
                $car_data['all_images'] = str_replace('thumb_', '', implode("|", $images));
               
                $to_return[] = $car_data;
           }

           return $to_return;
       },
   //'images_regx'       => '/"url":"(?<img_url>[^"]+)/',
    'next_query_regx' => '/"next(?<param>Page)":(?<value>[0-9]+)/',
    
);
add_filter('filter_richmondhondacom_car_data', 'filter_richmondhondacom_car_data');


function filter_richmondhondacom_car_data($car_data) {
    //taking all cars except Corvette

    $car_data['kilometres'] = str_replace(' kilometers','', $car_data['kilometres']);
   

    return $car_data;
}