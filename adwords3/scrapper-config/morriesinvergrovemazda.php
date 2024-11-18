<?php
global $scrapper_configs;
$scrapper_configs["morriesinvergrovemazda"] = array(
    'entry_points'        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP10636.csv',
    ),
    'use-proxy'           => true,
    'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'picture_selectors'   => ['.owl-item'],
    'picture_nexts'       => ['.owl-next'],
    'picture_prevs'       => ['.owl-prev'],
    'refine'              => false,
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);
        $result   = [];
        $vin_arr=array(
            'JTDKN3DU8D5664550',
            '3MVDMBAL0MM209847',
            '3MVDMBAL5MM209651',
            '3MVDMABL6MM209649',
            'JM3KFBCM3L0851366',
            'JM3KFBCM6L1834474',
            'JM3KFBCM7L0834604',
            'JM3KFBDM2L0833052',
            'JM3KFBDM1L0867158',
            'JM3KFBAY6M0306754',
            'JM3KFBAY3L0836727',
            'JM1BL1L34C1618089',
            '3MZBN1U7XHM134348',
            '3MZBN1V3XJM165262',
            
        );

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number'   => $vehicle['Stock #'],
                'vin'            => $vehicle['VIN'],
                'year'           => $vehicle['Year'],
                'stock_type'     => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                /*'make'           => $vehicle['Make'] == "Mazda" ? strtoupper($vehicle['Make']) : $vehicle['Make'],
                'model'          => $vehicle['Make'] == "Mazda" ? strtoupper($vehicle['Model']) : $vehicle['Model'],*/
                'make'           => $vehicle['Make'],
                'model'          => $vehicle['Model'],
                'title'          => $vehicle['Year'] . " " . $vehicle['Make'] . " " . $vehicle['Model'],
                'trim'           => $vehicle['Series'],
                'drivetrain'     => $vehicle['Drivetrain Desc'],
                'fuel_type'      => $vehicle['Fuel'],
                'transmission'   => $vehicle['Transmission'],
                'body_style'     => $vehicle['Body'],
                'images'         => explode('|', $vehicle['Photo Url List']),
                'all_images'     => $vehicle['Photo Url List'],
                'price'          => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
                'url'            => $vehicle['Vehicle Detail Link'],
                'exterior_color' => $vehicle['Colour'],
                'interior_color' => $vehicle['Interior Color'],
                'engine'         => $vehicle['Engine'],
                'description'    => strip_tags($vehicle['Description']),
                'kilometres'     => $vehicle['Odometer'],
            ];
            
              if(strpos($car_data['url'],"certified")){
                $car_data['stock_type']="certified";
            }
            $images = [];
            $images = explode('|', $car_data['all_images']);

            if (count($images) < 6) {
                $car_data['all_images'] = '';
            }
                        
//            if (isset($car_data['vin']) && in_array($car_data['vin'], $vin_arr)) {
//		continue;
//            }

            $result[] = $car_data;
        }

        return $result;
    }
);

add_filter('filter_morriesinvergrovemazda_car_data', 'filter_morriesinvergrovemazda_car_data');

function filter_morriesinvergrovemazda_car_data($car_data) {
    if (strtolower($car_data['make']) == 'mazda') {
        // $car_data['title'] = $car_data['year'] . " MAZDA" . strtoupper($car_data['model']);
        // $car_data['title'] = str_replace("MAZDAMAZDA", "MAZDA", $car_data['title']);
        $title = "MAZDA" . strtoupper($car_data['model']);
        $title = str_replace("MAZDAMAZDA", "MAZDA", $title);

        if (strlen($title) > 6) {
            $title = str_replace("MAZDA", "MAZDA ", $title);
        }

        $car_data['title'] = strtoupper($car_data['year'] . " " . $title);
    }

    return $car_data;
}