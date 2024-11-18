<?php
global $scrapper_configs;
$scrapper_configs["sydneyrvgroupcomau"] = array( 
	 'entry_points'        => array(
        'new'  => 'https://www.sydneyrv.com.au/DesktopModules/NetEngine.Modules.Api/API/VehicleSearch/Search?limit=1000&listingType=new&offset=0&sort=featured%20desc',
        'used' => 'https://www.sydneyrv.com.au/DesktopModules/NetEngine.Modules.Api/API/VehicleSearch/Search?limit=30&listingType=used&offset=0&sort=featured%20desc',
        
    ),
    'vdp_url_regex'       => '/\/vehicle-detail/i',
    'required_params'   => array('id'),
    'use-proxy'           => true,
    
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
        }

        $to_return = array();

        foreach ($objects as $obj) {

            $car_data = array(
                'stock_number'   => !empty($obj->StockNumber) ? $obj->StockNumber : $obj->Id,
                'stock_type'     => strtolower($obj->ListingType),
                'year'           => $obj->Year,
                'make'           => $obj->Make,
                'model'          => preg_replace('/[^A-Za-z0-9 -]/', '', $obj->Model),
                'body_style'     => $obj->Category,
                'price'          => $obj->Price,
                'kilometres'     => $obj->Odometer,
                'fuel_type'      => $obj->FuelType,
                'url' 		 => "https://www.sydneyrv.com.au/vehicle-detail?id=" . $obj->Id,
                'description'    => strip_tags($obj->Description),
                'city'           => $obj->Location->City,   
                
            );
            $imgs=[];
            
            foreach($obj->Images as $key=>$value){
                    
                      $imgs[]=$value;
  
            }
            $car_data['all_images']=implode("|",$imgs);
            
            if($car_data['stock_type']=='demo'){
                $car_data['custom']="demo";
                $car_data['stock_type']="new";
            }
            else{
                $car_data['custom']=$car_data['stock_type'];
            }
            
            $car_data['custom']  = $obj->Location->City;  

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    
);