<?php

global $scrapper_configs;
$scrapper_configs["lombardtoyota"] = 
    array(
     'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/3352.csv'
        ),

        'vdp_url_regex'     => '/\.com\/auto\/(?:used|new)-/i',

        # Client side scrapping configuration
        'client_scrapping' => 
        [
            'enabled'   => true,

            'idx'       => 
            [
                'vin'   => '/<td class="details-overview_title">VIN<\/td>\s*<td class="details-overview_data">(?<vin>[^<]+)/'
            ],

            'data'      => 
            [
                'exterior_color'=> '/<td class="details-overview_title">Exterior Color<\/td>\s*<td class="details-overview_data">(?<exterior_color>[^<]+)/',
                'interior_color'=> '/<td class="details-overview_title">Interior Color<\/td>\s*<td class="details-overview_data">(?<interior_color>[^<]+)/',
                'kilometres'    => '/<td class="details-overview_title">Mileage<\/td>\s*<td class="details-overview_data">(?<kilometres>[^<]+)/',
                'engine'        => '/<td class="details-overview_title">Engine<\/td>\s*<td class="details-overview_data">(?<engine>[^<]+)/'
            ]
        ],

        'use-proxy' => true,
        'picture_selectors' => ['div.cld-vehicle-img-wrapper img'],
        'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],

        'custom_data_capture' => function($url, $resp) 
        {
            $vehicles = csv_real_decode($resp);
            
            $db_connect = DbConnect::get_instance('lombardtoyota');
            
            #Update
            $query = "SELECT * FROM lombardtoyota_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) 
            {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) 
            {
                $car_data = 
                [
                    'stock_number'  => $vehicle['Stock'],
                    'vin'           => $vehicle['VIN'],
                    'year'          => $vehicle['Year'],
                    'make'          => $vehicle['Make'],
                    'model'         => $vehicle['Model'],
                    'trim'          => $vehicle['Trim'],
                    'drivetrain'    => $vehicle['Drivetrain'],
                    'fuel_type'     => $vehicle['Fuel_Type'],
                    'transmission'  => $vehicle['Transmission_Description'],
                    'body_style'    => $vehicle['Body'],
                    'images'        => explode(',', $vehicle['ImageList']),
                    'all_images'    => implode('|', explode(',', str_replace('"','',$vehicle['ImageList']))),
                    'price'         => $vehicle['SellingPrice']>0?$vehicle['SellingPrice']:$vehicle['MSRP'],
                    'url'           => "https://www.lombardtoyota.com/auto/*/" . $vehicle['VIN'],
                    'stock_type'    => strtolower($vehicle['Type']),
                    'exterior_color'=> $vehicle['ExteriorColor'],
                    'interior_color'=> $vehicle['InteriorColor'],
                    'engine'        => $vehicle['EngineDisplacement'],
                    'msrp'          => $vehicle['MSRP'],
                    'description'   => $vehicle['Description'],
                    'kilometres'    => $vehicle['Miles'],

                ];
                
                if (key_exists($car_data['vin'], $current_cars)) 
                {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
                    
                if (contains('new', $car_data['stock_type'])) 
                {
                    $car_data['stock_type'] = 'new';
                } 
                else 
                {
                    $car_data['stock_type'] = 'used';
                }
                
                $result[] = $car_data;
            }
            
            return $result;
        }
    );