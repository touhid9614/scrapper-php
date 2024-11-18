
<?php
global $scrapper_configs;
$scrapper_configs["rushmorehondacom"] = array(
    'entry_points'        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/DennyMenholtRushmoreHondaSM.csv',
    ),
    'vdp_url_regex'       => '/\/(?:auto|search)\/(?:new|used|New|Used|Pre-Owned)-/i',
    # Client side scrapping configuration
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
    'custom_data_capture' => function ($url, $data) {
        $vehicles = convert_CSV_to_JSON($data);
        $db_connect = DbConnect::get_instance('rushmorehondacom');

        #Update
        $query = "SELECT * FROM rushmorehondacom_scrapped_data WHERE url NOT LIKE '%/*/%' AND deleted = 0";

        $resp = $db_connect->query($query);

        $current_cars = [];

        while ($row = mysqli_fetch_assoc($resp)) {
            $current_cars[$row['vin']] = $row;
        }

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number'   => $vehicle['stockNumber'],
                'vin'            => $vehicle['vin'],
                'year'           => $vehicle['year'],
                'make'           => $vehicle['make'],
                'model'          => $vehicle['model'],
                'trim'           => $vehicle['trim'],
                'body_style'     => $vehicle['body'],
                'engine'         => $vehicle['engine'],
                'drivetrain'     => $vehicle['drive'],
                'transmission'   => $vehicle['transmission'],
                'fuel_type'      => $vehicle['fuel'],
                'images'         => explode(',', $vehicle['imageUrls']),
                'all_images'     => implode('|', explode(',', $vehicle['imageUrls'])),
                'price'          => $vehicle['internetPrice'],
                'url'            => "https://www.rushmorehonda.com/auto/*/" . $vehicle['vin'],
                'stock_type'     => $vehicle['newUsed'],
                'exterior_color' => $vehicle['exteriorColor'],
                'kilometres'     => $vehicle['mileage'],
            ];

            if (key_exists($car_data['vin'], $current_cars)) {
                $car_data['url'] = $current_cars[$car_data['vin']]['url'];
                $car_data        = array_merge($current_cars[$car_data['vin']], $car_data);
            }

            if (contains('New', $car_data['stock_type'])) {
                $car_data['stock_type'] = 'new';
            } else {
                $car_data['stock_type'] = 'used';
            }

            $result[] = $car_data;
        }

        return $result;
    }
);