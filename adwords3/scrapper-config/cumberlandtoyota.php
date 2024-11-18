<?php

global $scrapper_configs;

$scrapper_configs["cumberlandtoyota"] = array(
  'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/cumberlandtoy.csv'
        ),
        'vdp_url_regex'     => '/\/auto\/(?:used|new)-/i',
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
        'picture_selectors' => ['.cld-vehicle-img-wrapper'],
        'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],
        'custom_data_capture' => function($url, $resp) {
            $vehicles = convert_CSV_to_JSON($resp);
            
            $db_connect = DbConnect::get_instance('cumberlandtoyota');
            
            #Update
            $query = "SELECT * FROM cumberlandtoyota_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {
                $car_data = [
                    'stock_number'  => $vehicle['Stock number'],
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
                    'price'         => $vehicle['Price'],
                    'url'           => "https://www.cumberlandtoyota.com/auto/*/" . $vehicle['VIN'],
                    'stock_type'    => str_replace('"','',$vehicle['Stock Type']),
                 

                ];
                
                if(key_exists($car_data['vin'], $current_cars)) {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    slecho("faul url:" . $car_data['url']);
                    $explo_url=explode("wtai", $car_data['url']);
                    $explo_url1=explode("toyota-mainten", $explo_url[0]);
                    $car_data['url']=$explo_url1[0];
                    slecho("ghfh:" . $explo_url1[0]);
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
                
                $result[] = $car_data;
            }
            
            return $result;
        }
    );