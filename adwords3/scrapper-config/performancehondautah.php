<?php

global $scrapper_configs;

$scrapper_configs['performancehondautah'] = array(
    "entry_points"        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/PerfomanceHondaBoutnifulPHOTOS.csv',
    ),
    'use-proxy'           => true,
    'srp_page_regex'      => '/\/search\/(?:new|used|certified)/i',
    'vdp_url_regex'       => '/\/inventory\//',
    'refine'              => false,
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            if(strpos($vehicle['WebsiteVDPURL'],"www.performancehondabountiful.com")){
                slecho("this vehicles is from www.performancehondabountiful.com domain");
            }
            else{
                slecho("this vehicles is not from www.performancehondabountiful.com domain");
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

            $ignore_data=[
                'C1667522',
                'PB060214',
                'PB060488',
            ];
    
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                continue;

            }

            $result[] = $car_data;
        }

        return $result;
    }
);