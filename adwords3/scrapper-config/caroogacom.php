<?php
global $scrapper_configs;
$scrapper_configs["caroogacom"] = array( 
     'entry_points' => array(
        'all' => 'http://tm.smedia.ca/adwords3/client-data/ffun/carooga-inventory-for-smedia.csv'
    ),
        'vdp_url_regex'         => '/com\/vehicle\//',
        'use-proxy'         => true,
        'refine' => false,
        'picture_selectors' => ['.view_all_images_wrapper'],
        'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],
    
    
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Trim'],

                'drivetrain' => $vehicle['Drivetrain'],
                'fuel_type' => $vehicle['Fuel_Type'],
                'transmission' => $vehicle['Transmission_Description'],

                'body_style' => $vehicle['Body'],
                'images' => explode('|', $vehicle['ImageList']),

                'all_images' => $vehicle['ImageList'],

                'price' => $vehicle['SellingPrice'],

                'url' => $vehicle['VDP URL'],

              

                'stock_type'    => strtolower($vehicle['Vehicle Condition(Stock Type)']),

                'exterior_color' => $vehicle['ExteriorColor'],
                'interior_color' => $vehicle['InteriorColor'],
                'engine' => $vehicle['Engine_Description'],
                'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['Mileage'],
            ];


            $result[] = $car_data;
        }

        return $result;
    }
);

