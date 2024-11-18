<?php
global $scrapper_configs;
$scrapper_configs["brucenissancom"] = array( 
	 'entry_points' => array(
            'used'   => 'https://www.brucenissan.com/en/used-inventory/api/listing?limit=500', 
            'new'   => 'https://www.brucenissan.com/en/new-inventory/api/listing?limit=500',  
            
             
           
        ),
         'srp_page_regex'     => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
        'vdp_url_regex'     => '/\/nissan\//i',
       
                    'use-proxy'         => true,
                   'refine'            => false,
                   'picture_selectors' => ['.ril-inner img'],
                   'picture_nexts'     => ['.next-button'],
                   'picture_prevs'     => ['.prev-button'],
                   'content_type'      => 'application/json',
                   'custom_data_capture'   => function($url, $data){

                   $objects = json_decode($data);


                   if(!$objects) {
                       //slecho($data);
                        return array();
                   }


                   $to_return = array();
           foreach ($objects->vehicles as $obj) {
              $stock_type = $obj->newVehicle ? "new" : "used";
              $car_data = array(
                'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->serialNo,
                'year' => $obj->carYear,
                'make' => $obj->model->make->name,
                'model' => $obj->model->name,
                'trim' => $obj->trim->name,
               'price'  => $obj->price,
                'transmission' => $obj->characteristics->transmission->type,
                'kilometres' => $obj->odometer,
                'vin' => $obj->serialNo,
                'drivetrain' => $obj->characteristics->transmission->driveTrain->label,
                'url' => "https://www.brucenissan.com/en/used-inventory/" .strtolower($obj->model->make->name) . '/' . str_replace(" ","-",strtolower($obj->model->name)) . '/' . $obj->carYear . '-' .strtolower($obj->model->make->name) . '-' . str_replace(" ","-",strtolower($obj->model->name )). '-id' . $obj->id,
                'all_images' => $obj->mainPicture->url ? "https://img.sm360.ca/images/inventory" . $obj->mainPicture->url : '',
            );
            $images = [];
                
                    foreach ($obj->pictures as $picture) {
                        $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
                    }
                         
                          $car_data['all_images'] = implode("|", $images);

                          $to_return[] = $car_data;
                       }
                       
                          
                   return $to_return;
               },
     
     );