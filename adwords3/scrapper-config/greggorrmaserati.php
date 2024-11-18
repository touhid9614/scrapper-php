<?php
global $scrapper_configs;
 $scrapper_configs["greggorrmaserati"] = array( 
	'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/GreggOrrMaseratiShreveportSM.csv'
        ),
        'vdp_url_regex'     => '/\.com\/auto\/(?:used|new)-/i',
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
        'picture_nexts'     => ['.arrow_next_controls_btn'],
        'picture_prevs'     => ['.arrow_prev_controls_btn'],
        'custom_data_capture' => function($url, $resp) {
            $vehicles = csv_real_decode($resp);
            
            $db_connect = DbConnect::get_instance('greggorrmaserati');
            
            #Update
            $query = "SELECT * FROM greggorrmaserati_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {
                $car_data = [
                    'stock_number'  => $vehicle['stockNumber'],
                    'vin'           => $vehicle['vin'],
                    'year'          => $vehicle['year'],
                    'make'          => $vehicle['make'],
                    'model'         => $vehicle['model'],
                    'trim'          => $vehicle['trim'],
                    'body_style'    => $vehicle['body'],
                    'engine'        => $vehicle['engine'],
                    'drivetrain'    => $vehicle['drive'],
                    'transmission'  => $vehicle['transmission'], 
                    'fuel_type'     => $vehicle['fuel'],
                    'images'        => explode(',', $vehicle['imageUrls']),
                    'all_images'    => implode('|', explode(',', $vehicle['imageUrls'])),
                    'price'         => $vehicle['internetPrice']>0?$vehicle['internetPrice']: $vehicle['retail'],
                    'url'           => "https://www.greggorrmaserati.com/auto/*/" . $vehicle['vin'],
                    'stock_type'    => $vehicle['newUsed'],
                    'exterior_color'=> $vehicle['exteriorColor'],
                    'interior_color'=> $vehicle['interiorColor'],
                    'description'   => str_replace(['<br>','</br>','<b>','</b>'], ['','','',''],$vehicle['description']),
                    'kilometres'    => $vehicle['mileage'],

                ];
                
                if(key_exists($car_data['vin'], $current_cars)) {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
                    
                if(contains('New', $car_data['stock_type'])) {
                    $car_data['stock_type'] = 'new';
                } else {
                    $car_data['stock_type'] = 'used';
                }
                
                $result[] = $car_data;
            }
            
            return $result;
        }
    );