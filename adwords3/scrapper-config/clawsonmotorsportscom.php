<?php
global $scrapper_configs;
$scrapper_configs["clawsonmotorsportscom"] = array( 
	 'entry_points'        => array(
           'used'   => 'https://www.clawsonmotorsports.com/Vehicle/GetVehicleListViewModels',
           'new'    => 'https://www.clawsonmotorsports.com/Vehicle/GetVehicleListViewModels',
          
        
    ),
    'vdp_url_regex'     => '/(?:New|PreOwned)-[0-9]{4}-/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'custom_data_capture' => function($url, $resp){
           
           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory->Data as $obj)
           {
               
               $car_data = array(

                   //'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->Stock)?$obj->Stock:$obj->StockEncoded,
                   'year'              => $obj->Year,
                   'make'              => $obj->MakeDivision,
                   'model'             => $obj->ModelSubModel,
                   'body_style'        => $obj->StyleName,
                   'price'             => $obj->OurPrice,
                   'kilometres'        => $obj->Mileage,
                  // 'deleted'           => $obj->Sold?1:0,
                   'url'               => $obj->Url,
                   'exterior_color'    => $obj->ExteriorColorFormatted,
                   'vin'               => $obj->VIN,
                   'engine'            => $obj->Drivetrain,
                   'drivetrain'        => $obj->Drivetrain,
                   'fuel_type'         => $obj->FuelType,
                   'description'       => $obj->DescriptionFromProperties,
                   //'stock_type'        => strpos($obj->DescriptionFromProperties,

               );
               if(strpos($obj->Url,"New")){
                $car_data['stock_type']="new";
                }
                
                if(strpos($obj->Url,"Used")){
                $car_data['stock_type']="used";
                }
                
               $temp_data = HttpGet($car_data['url']);

            $description_regex    = '/<meta property="og:description" content="(?<description>[^"]+)/';

            $matches = array();

            if(preg_match($description_regex, $temp_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }


               $to_return[] = $car_data;
           }

           return $to_return;
       },
       'description'  => '/<meta property="og:description" content="(?<description>[^"]+)/',
      'images_regx'       => '/<div data-target="#main-image-carousel"[^>]+><img src="(?<img_url>[^"]+)"/',
   
);
    