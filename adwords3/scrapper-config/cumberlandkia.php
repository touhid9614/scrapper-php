
<?php
global $scrapper_configs;
$scrapper_configs["cumberlandkia"] = array(
    'entry_points'        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/cumberlandkia.csv',
    ),
    'vdp_url_regex'       => '/\/auto\//i',
    'client_scrapping'    => [
        'enabled' => true,
        'idx'     => [
            'vin' => '/<td class="details-overview_title">VIN<\/td>\s*<td class="details-overview_data">(?<vin>[^<]+)/',
        ],
        'data'    => [
            'exterior_color' => '/<td class="details-overview_title">Exterior Color<\/td>\s*<td class="details-overview_data">(?<exterior_color>[^<]+)/',
            'interior_color' => '/<td class="details-overview_title">Interior Color<\/td>\s*<td class="details-overview_data">(?<interior_color>[^<]+)/',
            'kilometres'     => '/<td class="details-overview_title">Mileage<\/td>\s*<td class="details-overview_data">(?<kilometres>[^<]+)/',
            'engine'         => '/<td class="details-overview_title">Engine<\/td>\s*<td class="details-overview_data">(?<engine>[^<]+)/',
        ],
    ],
    'use-proxy'           => true,
    'picture_selectors'   => ['.cld-vehicle-img-wrapper'],
    'picture_nexts'       => ['.dep_image_slider_alt_next_btn'],
    'picture_prevs'       => ['.dep_image_slider_alt_prev_btn'],
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);
        $db_connect = DbConnect::get_instance('cumberlandkia');

        #Update
        $query = "SELECT * FROM cumberlandkia_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";

        $resp = $db_connect->query($query);
        $current_cars = [];

        while ($row = mysqli_fetch_assoc($resp)) {
            $current_cars[$row['vin']] = $row;
        }

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock number'],
                'vin'          => $vehicle['VIN'],
                'year'         => $vehicle['Year'],
                'make'         => $vehicle['Make'],
                'model'        => $vehicle['Model'],
                'trim'         => $vehicle['Trim'],
                'body_style'   => $vehicle['Body style'],
                'drivetrain'   => $vehicle['Drivetrain'],
                'transmission' => $vehicle['Transmission'],
                'fuel_type'    => $vehicle['Fuel type'],
                'images'       => explode(',', $vehicle['Images']),
                'all_images'   => implode('|', explode(',', $vehicle['Images'])),
                'price'        => $vehicle['Price'],
                'url'          => $vehicle['VDP URL'],
                'stock_type'    => $vehicle['Stock Type'],
            ];

              // if(key_exists($car_data['vin'], $current_cars)) 
              //   {
              //       $car_data['url'] = $current_cars[$car_data['vin']]['url'];
              //       $car_data = array_merge($current_cars[$car_data['vin']], $car_data);
              //   }
                    
                if(contains('new', $car_data['stock_type']))
                {
                    $car_data['stock_type'] = 'new';
                } else 
                {
                    $car_data['stock_type'] = 'used';
                }
           
                $result[] = $car_data;
            }

        return $result;
    }
);

add_filter('filter_cumberlandkia_car_data', 'filter_cumberlandkia_car_data');

function filter_cumberlandkia_car_data($car_data)
{
    if ($car_data['stock_number'] === '4178480') {
        slecho("Excluding car that has stock number 4178480 ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}