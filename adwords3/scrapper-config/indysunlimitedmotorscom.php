<?php

global $scrapper_configs;

$scrapper_configs["indysunlimitedmotorscom"] = array(
    'entry_points'        => array(
        'used' => 'https://www.indysunlimitedmotors.com/Inventory/Search?version=2&startIndex=0',
    ),
    'vdp_url_regex'       => '/\/detail\/[0-9]{4}-/',
    'srp_page_regex'      => '/\/pre-owned-cars/',
    'use-proxy'           => true,
    'content_type'        => 'application/json',
    'picture_selectors'   => [],
    'picture_nexts'       => [],
    'picture_prevs'       => [],

    'custom_data_capture' => function ($url, $data) {
        $base_url   = 'https://www.indysunlimitedmotors.com/Inventory/Search?version=2&startIndex=';
        $startIndex = 0;
        $dataLoad   = json_decode($data);
        $carLimit   = $dataLoad->totalResults;
        $to_return  = [];

        while ($carLimit > 0) {
            $api_data = HttpGet($base_url . $startIndex, true, true);
            $objects  = json_decode($api_data);

            if ($objects) {
                foreach ($objects->vehicles as $obj) {
                    if (!$obj->IsSold) {
                        $car_data = array(
                            'stock_number'   => $obj->StockNo ? $obj->StockNo : $obj->Vin,
                            'vin'            => $obj->Vin,
                            'year'           => $obj->Year,
                            'make'           => $obj->Make,
                            'model'          => $obj->Model,
                            'trim'           => $obj->Trim,
                            'price'          => $obj->FinalPrice,
                            'engine'         => $obj->Engine,
                            'transmission'   => $obj->Transmission,
                            'kilometres'     => $obj->Mileage,
                            'url'            => "https://www.indysunlimitedmotors.com" . $obj->VehicleDetailUrl,
                            'exterior_color' => $obj->FactoryColorTex,
                            'interior_color' => $obj->FactoryInteriorText,
                            'certified'      => $obj->CertifiedStatus ? 1 : 0,
                            'city'           => $obj->DealerLocationId,
                        );
                        if($car_data['price']<=0){
                            $car_data['price']='';
                        }
                        
                        
                        $to_return[] = $car_data;
                    }
                }
            }

            $startIndex += 15;
            $carLimit   -= 15;
        }

        return $to_return;
    },
    'images_regx'         => '/<a href="(?<img_url>[^"]+)"\s*data-lightbox="vehicle-images">/',
);