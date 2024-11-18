<?php

global $scrapper_configs;

$scrapper_configs['performancefordbountiful'] = array(
    "entry_points"        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/PerformanceFordBountifulPHOTOS.csv',
    ),
    'use-proxy'           => true,
    //'required_params'   => array('vehicleId'),
    'srp_page_regex'      => '/\/search\/(?:new|used|certified)/i',
    'vdp_url_regex'       => '/\/inventory/i',
    
    'refine'              => false,
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];
        
        foreach ($vehicles as $vehicle) {
            
            if(strpos($vehicle['WebsiteVDPURL'],"www.performancefordbountiful.com")){
                slecho("this vehicles is from www.performancefordbountiful.com domain");
            }
            else{
                slecho("this vehicles is not from www.performancefordbountiful.com domain");
                continue;
            }

            $car_data = [
                'stock_number'   => $vehicle['Stock'],
                'vin'            => $vehicle['VIN'],
                'year'           => $vehicle['Year'],
                'make'           => $vehicle['Make'],
                'model'          => $vehicle['Model'],
                'trim'           => $vehicle['Trim'],
                'drivetrain'     => $vehicle['Drivetrain'],
                'fuel_type'      => $vehicle['Fuel_Type'],
                'transmission'   => $vehicle['Transmission'],
                'body_style'     => $vehicle['Body'],
                // 'images'        => explode(',', $vehicle['ImageList']),
                'all_images'    => implode('|', explode(',', $vehicle['ImageList'])),
                'price'          => $vehicle['SellingPrice']==0?-1:$vehicle['SellingPrice'],
                //'price'          => $vehicle['SellingPrice'] < $vehicle['MSRP']  ? $vehicle['SellingPrice']: $vehicle['MSRP'],
                'url'            => $vehicle['WebsiteVDPURL'],
                'stock_type'     => strtolower($vehicle['Type']),
                'engine'         => $vehicle['EngineDisplacement'],
                'msrp'           => $vehicle['MSRP'],
                'kilometres'     => $vehicle['Miles'],
                'exterior_color' => $vehicle['ExteriorColor'],
                'interior_color' => $vehicle['InteriorColor'],
            ];
    
            $result[] = $car_data;
        }

        return $result;
    }
);
