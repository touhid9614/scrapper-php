<?php
    global $scrapper_configs;

    $scrapper_configs['trucksandimports'] = array(
        'entry_points' => array(
            'used'   => 'http://www.trucksandimports.com/Inventory/Search?BodyType=&Year=&Make=&Model=&PriceRange=&Condition=pre-owned-cars&Color=&InteriorColor=&CityMpg=&HighwayMpg=&Transmission=&DriveTrain=&Fuel=&SearchExpression=&SortCriteria=&SortDirection=&LocationId=&IsCertified=-1&IsSold=False&startIndex=10&Results=1000',
         ),
        'vdp_url_regex'         => '/\/detail\/[0-9]{4}-/',
        'use-proxy'             => true,
        'content_type'          => 'application/json',
        'picture_selectors' => [],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'custom_data_capture'   => function($url, $data){
        
            $start_tag  = '<div id="ds-vehicles-json" data-json="';
            $end_tag    = '"></div>';

           if (stripos($data, $start_tag)) {
                $resp = substr($data, stripos($data, $start_tag) + strlen($start_tag));
            }

            if (stripos($data, $end_tag)) {
              $resp = substr($data, 0, stripos($data, $end_tag));
            }
            $objects = json_decode(str_replace('&quot;','"',$data));
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->vehicles as $obj)
            {
                if ($obj->IsSold == 1) { continue;}
                
                $car_data = array(
                    'stock_number'      => $obj->StockNo?$obj->StockNo:$obj->Vin,
                   // 'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->Year,
                    'make'              => $obj->Make,
                    'model'             => $obj->Model,
                    'trim'              => $obj->Trim,
                    //'body_style'        => $obj->bodystyle,
                    'price'             => $obj->FinalPrice,
                    'engine'            => $obj->Engine,
                    'transmission'      => $obj->Transmission,
                    'kilometres'        => $obj->Mileage,
                    'url'               => "http://www.trucksandimports.com/pre-owned-cars/detail/{$obj->Year}-{$obj->Make}-{$obj->Model}/{$obj->VehicleId}",
                    'exterior_color'    => $obj->FactoryColorTex,
                    'interior_color'    => $obj->FactoryInteriorText,
                    'certified'         => $obj->CertifiedStatus?1:0,
                    //'images'            => $obj->picture
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx'     =>'/thumbnail ds-detail-thumb">\s*<img.*data-src="(?<img_url>[^"]+)/',
    );
    
    