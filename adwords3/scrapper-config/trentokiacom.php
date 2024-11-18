<?php
global $scrapper_configs;
$scrapper_configs["trentokiacom"] = array( 
	'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/trentokia_en.csv'
    ),
      'vdp_url_regex'         => '/\/en\/(?:catalog|inventory|new-catalog)\//',
         'use-proxy'         => true,
       'refine' => false,
        'picture_selectors' => ['.car-images'],
        'picture_nexts'     => ['.swiper-button-next.carousel__navigation.carousel__navigation--next'],
        'picture_prevs'     => ['.swiper-button-prev.carousel__navigation.carousel__navigation--prev'],
    
    
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['stock'],
                'vin' => $vehicle['vin'],
              //  'stock_type' => $vehicle['is_new'] == "TRUE" ? "new" : "new",
                'stock_type' => $vehicle['is_new'] == "true" ? "new" : "used",
                'year' => $vehicle['year'],
                'make' => $vehicle['make'],
                'model' => $vehicle['model'],
                'trim' => $vehicle['trim'],
                'drivetrain' => $vehicle['drive'],
                'fuel_type' => $vehicle['fuel'],
                'transmission' => $vehicle['transmission'],
                'body_style' => $vehicle['body'],
                 'images'        => explode(',', $vehicle['photo']),
                 'all_images'    => implode('|', explode(',', $vehicle['photo'])),   
                'price' => $vehicle['standard_price'],
                'url' => $vehicle['external_url'],
               // 'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['extcolour'],
                'interior_color' => $vehicle['intcolour'],
                'engine' => $vehicle['eng_desc'],
                'description' => strip_tags($vehicle['description']),
                'kilometres' => $vehicle['odometer'],
            ];


            $result[] = $car_data;
        }

        return $result;
    }
);
