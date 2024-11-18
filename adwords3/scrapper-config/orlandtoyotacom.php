<?php
global $scrapper_configs;
$scrapper_configs["orlandtoyotacom"] = array( 
	'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP2958.csv'
    ),
    'vdp_url_regex' => '/\/auto\//i',
    'ty_url_regex' => '/\/form\/confirm/i',
    'use-proxy' => true,
    'refine' => false,
     'srp_page_regex'       => '/\/search/\/i',
    'picture_selectors' => ['.preview_vehicle_image_item'],
    'picture_nexts' => ['.arrow_next_controls_btn'],
    'picture_prevs' => ['.arrow_prev_controls_btn'],
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock #'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Series'],
                'drivetrain' => $vehicle['Drivetrain'],
                'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['Transmission'],
                'body_style' => $vehicle['Body'],
                'images' => explode('|', $vehicle['Photo Url List']),
                'all_images' => $vehicle['Photo Url List'],
                'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
                 'url' => $vehicle['Vehicle Detail Link'],
                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['Colour'],
                'interior_color' => $vehicle['Interior Color'],
                'engine' => $vehicle['Engine'],
                'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['Odometer'],
            ];


            $result[] = $car_data;
        }

        return $result;
    }
);
