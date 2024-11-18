<?php
global $scrapper_configs;
 $scrapper_configs["minihalifaxca"] = array( 
    'entry_points' => array(
        'used'  => 'https://www.minihalifax.ca/en/shopping/mini-next/list',
        'new'   => 'https://minihalifax.ca/en/shopping/inventory',
        
    ),
    'vdp_url_regex'     => '/\/en\/shopping\/[^\/]+\/(?:2110|detail)/i',
    
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.item img'],
    'picture_nexts'     => ['.auto-gallery-right'],
    'picture_prevs'     => ['.auto-gallery-left'],

    'custom_data_capture' => function($url, $resp){
           $start_tag  = 'var FullVehicleList = ';
           $end_tag    = '}];';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }
           $resp=$resp . '}]';
           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {    
               
               if($obj->km != 90)   
               {
                   $url="https://www.minihalifax.ca/en/shopping/mini-next/detail/";
               }
               else 
               {
                   $url="https://minihalifax.ca/en/shopping/inventory/detail/2110/";
               }
               $car_data = array(

                   'transmission'      => $obj->Transmission,
                   'vin'               => !empty($obj->VIN)?$obj->VIN:$obj->StockNumber,
                   'stock_number'      => !empty($obj->StockNumber)?$obj->StockNumber:$obj->VIN,
                   'year'              => $obj->Year,
                   'make'              => $obj->Make,
                   'model'             => $obj->Model,
                   'body_style'        => $obj->BodyColour,
                   //'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->Price)?$obj->Price :(!empty($obj->Price)?$obj->Price:'Call for Price'),
                   'kilometres'        => $obj->KM,
                  // 'url'               => "http://www.alexandriacampingcentre.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url . $obj->StockNumber,
                   'exterior_color'    => $obj->BodyColour,
                   'interior_color'    => $obj->InteriorColour,
                   'engine'            => $obj->Engine,
                   'msrp'              => $obj->BaseMSRP,
                   'drivetrain'        => $obj->DriveTrain,
                   'trim'              => $obj->Trim,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'            => '/<img alt="car img" src="(?<img_url>[^"]+)"/',
    
);