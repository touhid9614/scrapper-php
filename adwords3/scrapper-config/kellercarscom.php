<?php
global $scrapper_configs;
$scrapper_configs["kellercarscom"] = array( 
	  'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/kellermotors.csv'
    ),
    'vdp_url_regex' => '/\.com\/auto\/(?:used|new|)/i',
    # Client side scrapping configuration
    'client_scrapping' => [
        'enabled' => true,
        'idx' => [
            'vin' => '/<td class="details-overview_title">VIN<\/td>\s*<td class="details-overview_data">(?<vin>[^<]+)/'
        ],
        'data' => [
            'exterior_color' => '/<td class="details-overview_title">Exterior Color<\/td>\s*<td class="details-overview_data">(?<exterior_color>[^<]+)/',
            'interior_color' => '/<td class="details-overview_title">Interior Color<\/td>\s*<td class="details-overview_data">(?<interior_color>[^<]+)/',
            'kilometres' => '/<td class="details-overview_title">Mileage<\/td>\s*<td class="details-overview_data">(?<kilometres>[^<]+)/',
            'engine' => '/<td class="details-overview_title">Engine<\/td>\s*<td class="details-overview_data">(?<engine>[^<]+)/'
        ]
    ],
    'use-proxy' => true,
    'picture_selectors' => ['div.cld-vehicle-img-wrapper img'],
    'picture_nexts' => ['.dep_image_slider_alt_next_btn'],
    'picture_prevs' => ['.dep_image_slider_alt_prev_btn'],
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = csv_real_decode($resp);

        $db_connect = DbConnect::get_instance('hondaofhotsprings');

        #Update
        $query = "SELECT * FROM kellercarscom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";

        $resp = $db_connect->query($query);

        $current_cars = [];

        while ($row = mysqli_fetch_assoc($resp)) {
            $current_cars[$row['vin']] = $row;
        }

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock number'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Trim'],
                'drivetrain' => $vehicle['Drivetrain'],
                'fuel_type' => $vehicle['Fuel type'],
                'transmission' => $vehicle['Transmission'],
                'body_style' => $vehicle['Body style'],
                'images' => explode(',', $vehicle['Images']),
                'all_images' => implode('|', explode(',', $vehicle['Images'])),
                'price' => $vehicle['Price']=="0"?"Please Call":$vehicle['Price'],
                'url' => "https://www.kellercars.com/auto/*/" . $vehicle['VIN'],
                'stock_type' => strtolower($vehicle['Stock Type']),
                'exterior_color' => $vehicle['exteriorColor'],
                'interior_color' => $vehicle['interiorColor'],
                'engine' => $vehicle['engine'],
                'description' => $vehicle['description'],
                'kilometres' => $vehicle['mileage'],

            ];

            if (key_exists($car_data['vin'], $current_cars)) {
                $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
            }

            if (preg_match('/new/', $car_data['stock_type'])) {
                $car_data['stock_type'] = 'new';
            } elseif (preg_match('/used/', $car_data['stock_type'])) {
                $car_data['stock_type'] = 'used';
            }
            else{
                 $car_data['stock_type'] = 'certified';
            }

            $result[] = $car_data;
        }

        return $result;
    }
);