<?php

global $scrapper_configs;

$scrapper_configs['performancefordtrucklandcom'] = array(
    "entry_points"        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/PerformanceFordBountifulTC.csv',
    ),

    'use-proxy'           => false,
    'srp_page_regex'      => '/\/(?:new|used)-vehicles/i',
    'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified|certified-used)-[0-9]{4}-/i',
    'refine'              => false,

    'custom_data_capture' => function ($url, $resp) {
        $vehicles  = convert_CSV_to_JSON($resp);
        $photoUrl  = "https://tm.smedia.ca/adwords3/client-data/dealereprocess/PerformanceFordBountifulTCPHOTOS.csv";
        $photoResp = HttpGet($photoUrl, false, false);
        $photoJson = convert_CSV_to_JSON($photoResp);
        $photoData = [];
        $result    = [];

        foreach ($photoJson as $vehicle) {
            $photoData[trim($vehicle['VIN'])] = explode(',', $vehicle['ImageList']);
        }

        foreach ($vehicles as $vehicle) {
            if (!(strpos($vehicle['WebsiteVDPURL'], "www.performancefordtruckcountry.com"))) {
                continue;
            }

            $car_data = [
                'stock_number'   => $vehicle['Stock'],
                'vin'            => trim($vehicle['VIN']),
                'year'           => $vehicle['Year'],
                'make'           => $vehicle['Make'],
                'model'          => $vehicle['Model'],
                'trim'           => $vehicle['Trim'],
                'drivetrain'     => $vehicle['Drivetrain'],
                'fuel_type'      => $vehicle['Fuel_Type'],
                'transmission'   => $vehicle['Transmission'],
                'body_style'     => $vehicle['Body'],
                'images'         => $photoData[trim($vehicle['VIN'])],
                'all_images'     => implode('|', $photoData[trim($vehicle['VIN'])]),
                'price'          => $vehicle['SellingPrice'] == 0 ? $vehicle['MSRP'] : $vehicle['SellingPrice'],
                'url'            => $vehicle['WebsiteVDPURL'],
                'stock_type'     => strtolower($vehicle['Type']),
                'engine'         => $vehicle['EngineDisplacement'],
                'msrp'           => $vehicle['MSRP'],
                'kilometres'     => $vehicle['Miles'],
                'exterior_color' => $vehicle['ExteriorColor'],
                'interior_color' => $vehicle['InteriorColor'],
                'doors'          => $vehicle['Doors'],
                //'certified'      => $vehicle['Certified'],
                'description'    => $vehicle['Description'],
                'options'        => $vehicle['Options'],
                'passenger'      => $vehicle['PassengerCapacity'],
            ];

            $result[] = $car_data;
        }

        return $result;
    }
);

add_filter('filter_performancefordtrucklandcom_car_data', 'filter_performancefordtrucklandcom_car_data');

function filter_performancefordtrucklandcom_car_data($car_data)
{

    if ($car_data['price'] == "0" || $car_data['price'] == 0) {
        $car_data['price'] = "-1";
    }

    return $car_data;
}

// add_filter('filter_for_fb_performancefordtrucklandcom', 'filter_for_fb_performancefordtrucklandcom');
//
//function filter_for_fb_performancefordtrucklandcom($car)
//{
//    return $car;
//}
