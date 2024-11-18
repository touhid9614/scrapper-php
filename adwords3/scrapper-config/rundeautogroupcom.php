<?php
global $scrapper_configs;
$scrapper_configs["rundeautogroupcom"] = array( 
	   'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/RundeAutoGroup.csv',
           
        ),
        'vdp_url_regex'     => '/\/listings\//i',
        # Client side scrapping configuration
        'client_scrapping' => [
            'enabled'   => true,
            'idx'       => [
                'vin'   => '/VIN Number:\s*[^>]+>[^>]+>(?<vin>[^<]+)/'
            ],
            'data'      => [
                'exterior_color'=> '/Exterior Color:\s*[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
                'interior_color'=> '/Interior Color:\s*[^>]+>[^>]+>(?<interior_color>[^<]+)/',
                'kilometres'    => '/Mileage:\s*[^>]+>[^>]+>(?<kilometres>[^<]+)/',
                'engine'        => '/Engine:\s*[^>]+>[^>]+>(?<engine>[^<]+)/'
            ]
        ],
        'use-proxy' => true,
        'refine' => false,
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.slick-next'],
        'picture_prevs'     => ['.slick-prev'],
        'custom_data_capture' => function($url, $resp) {
            $vehicles = csv_real_decode($resp);
            
            $db_connect = DbConnect::get_instance('rundeautogroupcom');
            
            #Update
            $query = "SELECT * FROM rundeautogroupcom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {
                $car_data = [
                    'stock_number'  => $vehicle['Stock'],
                    'vin'           => $vehicle['VIN'],
                    'year'          => $vehicle['Year'],
                     'stock_type'    => strtolower($vehicle['Condition']),
                    'make'          => $vehicle['Make'],
                    'model'         => $vehicle['Model'],
                    'trim'          => $vehicle['Trim'],
                    'body_style'    => $vehicle['Body'],
                    'engine'        => $vehicle['Engine'],
                    'drivetrain'    => $vehicle['Drivetrain'],
                    'transmission'  => $vehicle['Transmission'], 
                    'fuel_type'     => $vehicle['vehic_fuel_type'],
                    'images'        => explode(',', $vehicle['ImageURLs']),
                    'all_images'    => implode('|', explode(',', $vehicle['ImageURLs'])),
                    'price'         => $vehicle['Price']=='0'?$vehicle['RetailPrice']:$vehicle['Price'],
                     'url'           => "https://www.rundeautogroup.com/listings/" .strtolower($vehicle['Condition'])."-" . $vehicle['Year'] . "-" . $vehicle['Make'] . "-" . strtolower(explode(" ",$vehicle['Model'])[0]). "-" . strtolower(explode(" ",$vehicle['Model'])[1]), 
                    'exterior_color'=> $vehicle['ExtColor'],
                    'interior_color'=> $vehicle['IntColor'],
                    'kilometres'    => $vehicle['Mileage'],

                ];
                 
                $result[] = $car_data;
        }
        return  $result;
    }
);