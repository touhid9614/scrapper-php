<?php
global $scrapper_configs;
 $scrapper_configs["joecottonfordcom"] = array( 
	 'entry_points' => array(
            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/smedia_from_dep.csv'
        ),
        'vdp_url_regex'     => '/.com\/auto\/(?:used|new)-/i',
     
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
        'custom_data_capture' => function($url,$data) {
            $vehicles = convert_CSV_to_JSON($data);
            
            $db_connect = DbConnect::get_instance('joecottonfordcom');
            
            #Update
            $query = "SELECT * FROM joecottonfordcom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";
            
            $resp = $db_connect->query($query);
            
            $current_cars = [];
            
            while($row = mysqli_fetch_assoc($resp)) {
                $current_cars[$row['vin']] = $row;
            }
            
            $result = [];
            
            foreach($vehicles as $vehicle) {

                if(preg_match("/joecottonford/", $vehicle['vdplink'])){

                $car_data = [
                    'stock_number'  => $vehicle['stock'],
                    'vin'           => $vehicle['VIN'],
                    'year'          => $vehicle['year'],
                    'make'          => $vehicle['make'],
                    'model'         => $vehicle['model'],
                    'trim'          => $vehicle['trim'],
                    //'body_style'    => $vehicle['Body'],
                    //'engine'        => $vehicle['Engine'],
                    'drivetrain'    => $vehicle['drivetrain'],
                    //'transmission'  => $vehicle['Transmission'], 
                    //'fuel_type'     => $vehicle['Fuel'],
                    'images'        => explode(',', $vehicle['imageurls']),
                    'all_images'    => implode('|', explode(',', $vehicle['imageurls'])),
                    'price'         => $vehicle['masterprice']==''?$vehicle['msrp']: $vehicle['masterprice'],
                    'url'           => "https://www.joecottonford.com/auto/*/" . $vehicle['VIN'],
                    'stock_type'    => $vehicle['newused'],
                    'exterior_color'=> $vehicle['extcolor'],
                    'interior_color'=> $vehicle['intcolor'],
                    //'description'   => str_replace(['<br>','</br>','<b>','</b>'], ['','','',''],$vehicle['Description']),
                    'kilometres'    => $vehicle['miles'],

                ];
                
                if(key_exists($car_data['vin'], $current_cars)) {
                    $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                    $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
                }
                
                    $result[] = $car_data;
                }
            }
            return $result;
        }
    );