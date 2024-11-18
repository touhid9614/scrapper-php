<?php
global $scrapper_configs;
$scrapper_configs["expresseagleridgegmcom"] = array( 
	"entry_points" => array(
	        'new'  => 'https://express.eagleridgegm.com/api/dealer_new_inventory?f=submodel%3A&sort=lowest%20price&large_inventory=1&request_vehicles=1',
             'used'   => 'https://express.eagleridgegm.com/api/dealer_used_inventory?f=submodel%3A&sort=lowest%20price&large_inventory=1&request_vehicles=1',
        
    ),
    'vdp_url_regex'     => '/\/express\//i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.u-dib .FlexEmbed-content img'],
    'picture_nexts'     => ['.Swipe-control--next button'],
    'picture_prevs'     => ['.Swipe-control--prev button'],

    'custom_data_capture' => function($url, $resp){
          
           $object = json_decode($resp);
           $inventory = $object->vehicles;

           $to_return = array();

           foreach($inventory as $obj)
           {
               
               $url="https://express.eagleridgegm.com/express/";
               
               $car_data = array(

                   'transmission'      => $obj->transmission->label,
                   'stock_number'      => !empty($obj->stock_number)?$obj->stock_number:$obj->vin,
                   'year'              => $obj->year,
                   'make'              => $obj->make,
                   'model'             => $obj->model,
                   'body_style'        => $obj->body,
                   'price'             => $obj->dealer_price?$obj->dealer_price:$obj->roadster_price,
                   'kilometres'        => $obj->mileage,
                   'url'               => $obj->used? $url . "used/" . $obj->vin : $url . $obj->vin ,
                   'exterior_color'    => $obj->exterior_color->label,
                   'vin'               => $obj->vin,
                   'engine'            => $obj->engine->label,
                   'drivetrain'        => $obj->drivetrain,
                   'fuel_type'         => $obj->engine->type,

               );


               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/images":\["(?<img_url>[^\]]+)\]/',
    
);
       
    add_filter("filter_expresseagleridgegmcom_field_images", "filter_expresseagleridgegmcom_field_images");
       
    function filter_expresseagleridgegmcom_field_images($im_urls)
    {
        $img=str_replace('"',"",$im_urls[0]);
        $img=explode(',',$img);
        
        return $img;
    }
    