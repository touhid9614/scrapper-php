<?php
global $scrapper_configs;
$scrapper_configs["edmondsautocreditcom"] = array( 
	'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/CAMPBELL.csv'
        ),
        'vdp_url_regex'     => '/\.com\/auto\/(?:used|new|certified)-/i',
        # Client side scrapping configuration
        'client_scrapping' => [
            'enabled'   => true,
            'idx'       => [
                'vin'   => '/<td class="details-overview_title">VIN<\/td>\s*<td class="details-overview_data">(?<vin>[^<]+)/'
            ],
            'data'      => [
                'exterior_color'=> '/<td class="details-overview_title">Exterior Color<\/td>\s*<td class="details-overview_data">(?<exterior_color>[^<]+)/',
                'interior_color'=> '/<td class="details-overview_title">Interior Color<\/td>\s*<td class="details-overview_data">(?<interior_color>[^<]+)/',
                'kilometres'    => '/<td class="details-overview_title">Mileage<\/td>\s*<td class="details-overview_data">(?<kilometres>[^<]+)/',
                'engine'        => '/<td class="details-overview_title">Engine<\/td>\s*<td class="details-overview_data">(?<engine>[^<]+)/'
            ]
        ],
        'use-proxy' => true,
        'picture_selectors' => ['.view_all_images_wrapper'],
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        'custom_data_capture' => function($url, $resp) {
            $vehicles = csv_real_decode($resp);
            
            $db_connect = DbConnect::get_instance('edmondsautocreditcom');
            
            #Update
            $query = "SELECT * FROM edmondsautocreditcom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {
             if(contains('new', $vehicle['Stock Type'])){
                continue;
            }
                $car_data = [
                    'stock_number'  => $vehicle['Stock number'],
                    'stock_type'    => str_replace('"','',$vehicle['Stock Type']),   
                    'vin'           => $vehicle['VIN'],
                    'year'          => $vehicle['Year'],
                    'make'          => $vehicle['Make'],
                    'model'         => $vehicle['Model'],
                    'trim'          => $vehicle['Trim'],
                    'body_style'    => $vehicle['Body style'],  
                    'drivetrain'    => $vehicle['Drivetrain'],
                    'transmission'  => $vehicle['Transmission'], 
                    'fuel_type'     => $vehicle['Fuel type'],
                    'images'        => explode(',', $vehicle['Images']),
                    'all_images'    => implode('|', explode(',', $vehicle['Images'])),
                    'price'         => $vehicle['Price']==0?'Please Call':$vehicle['Price'],
                    'url'           => "https://www.edmondsautocredit.com/auto/*/".$vehicle['VIN'],
                ];
               
                if(key_exists($car_data['vin'], $current_cars)) {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
            if(contains('certified', $car_data['stock_type'])) {
                        $car_data['stock_type'] ='used';
                } 
                if(contains('used', $car_data['stock_type'])) {
                        $car_data['stock_type'] ='used';
                } 
            
                $result[] = $car_data;
           
            }
            return $result;
        }
    );