<?php
global $scrapper_configs;
 $scrapper_configs["bonifacehierschryslerdodgecom"] = array( 
	 'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/bonifacehierschryslerdodgejeepram.csv'
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
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        'custom_data_capture' => function($url,$data) {
            $vehicles = csv_real_decode($data);
            
            $db_connect = DbConnect::get_instance('bonifacehierschryslerdodgecom');
            
            #Update
            $query = "SELECT * FROM bonifacehierschryslerdodgecom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {
                $car_data = [
                    'stock_number'  => $vehicle['Stock #'],
                    'vin'           => $vehicle['VIN'],
                    'year'          => $vehicle['Year'],
                    'make'          => $vehicle['Make'],
                    'model'         => $vehicle['Model'],
                    'trim'          => $vehicle['Trim'],
                    'body_style'    => $vehicle['Body'],
                    'engine'        => $vehicle['Engine'],
                    'drivetrain'    => $vehicle['Drivetrain Desc'],
                    'transmission'  => $vehicle['Transmission'], 
                    'fuel_type'     => $vehicle['Fuel'],
                    'images'        => explode(',', $vehicle['Photo Url List']),
                    'all_images'    => implode('|', explode(',', $vehicle['Photo Url List'])),
                    'price'         => $vehicle['Price']==''?$vehicle['MSRP']: $vehicle['Price'],
                    'url'           => "https://www.bonifacehierschryslerdodge.com/auto/*/" . $vehicle['VIN'],
                    'stock_type'    => $vehicle['New/Used'],
                    'exterior_color'=> $vehicle['Colour'],
                    'interior_color'=> $vehicle['Interior Color'],
                    'description'   => str_replace(['<br>','</br>','<b>','</b>'], ['','','',''],$vehicle['Description']),
                    'kilometres'    => $vehicle['Odometer'],

                ];
                
                if(key_exists($car_data['vin'], $current_cars)) {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
                    
                if(contains('N', $car_data['stock_type'])) {
                    $car_data['stock_type'] = 'new';
                } else {
                    $car_data['stock_type'] = 'used';
                }
                
                $result[] = $car_data;
            }
            
            return $result;
        }
    );