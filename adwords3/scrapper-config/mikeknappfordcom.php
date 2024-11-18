<?php
global $scrapper_configs;
$scrapper_configs["mikeknappfordcom"] = array( 
	"entry_points" => array(
        'new' => 'https://darrylfrith.com/mkf/api/v1/api/inventory/0/NEW',
        'used' => 'https://darrylfrith.com/mkf/api/v1/api/inventory/0/USED'
    ),
   'vdp_url_regex'     => '/\/inventory\//i',
    'required_params'   => array('stockID'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.flex11400.m20.ng-tns-c7-11.ng-star-inserted'],
    'picture_nexts'     => ['.Swipe-control--next button'],
    'picture_prevs'     => ['.Swipe-control--prev button'],

    'custom_data_capture' => function($url, $data){
     
        $objects = json_decode($data);               
        if(!$objects) { slecho($data); return array(); }        
        $to_return = array();

          foreach($objects->results as $obj)
        {
            //$obj = $obj->_source;
            $imgs=[];
            $car_data = array(
                'stock_number'      => $obj->stock_id?$obj->stock_id:$obj->vin,
                'stock_type'        => strtolower($obj->condition),
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body_style,
                'price'             => $obj->sale_price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->kms,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel,
                'drivetrain'        => $obj->drivetrain,    
                'url'               => "https://mikeknappford.com/inventory/listings/".strtolower($obj->condition)."?stockID=".$obj->stock_id,
                'exterior_color'    => $obj->color_ext,
                'interior_color'    => $obj->color_int,
                'all_images'        => $obj->images->image_key,
            
            );

            foreach($obj->images as $key=>$value){
                    $imgs[]="https://darrylfrith.com/mkf/api/uploadedImages/" . $value->image_key;
  
            }
            $car_data['all_images']=implode("|",$imgs);
          
            $to_return[] = $car_data;
        }

        return $to_return;
    },
      'images_regx' => '/swiper-lazy"\s*data-background="(?<img_url>[^"]+)"/'
);